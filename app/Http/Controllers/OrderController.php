<?php

namespace App\Http\Controllers;

use App\CustomResponse\ApiResponse;
use App\Events\AddNewOrderEvent;
use App\Events\OnGoingOrderEvent;
use App\Events\PastOrdersEvent;
use App\Events\ReadyToDeliverEvent;
use App\Http\Requests\OrderReviewRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PasOrderResource;
use App\Models\Order;
use App\Models\OrderCart;
use App\Models\SubOrder;
use App\Models\Table;
use App\SecurityChecker\Checker;
use App\Status\OrderStatus;
use App\Status\UserType;
use App\Traits\CustomResponse;
use App\Types\OrderTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $orders = SubOrder::all();

            return OrderResource::collection($orders);

        }catch (\Throwable $th){
            return $this->error(
                $th->getMessage(),
                500
            );
        }
    }

    public function indexByBranch($branchID)
    {
        try {
            $orders = SubOrder::where('branch_id' , $branchID)->get();

            return OrderResource::collection($orders);

        }catch (\Throwable $th){
            return $this->error(
                $th->getMessage(),
                500
            );
        }
    }


    public function readyOrders()
    {
        $orders = SubOrder::where('order_state' , OrderTypes::Ready)->get();
        return OrderResource::collection($orders);
    }
    public function readyOrdersByBranch($branchID)
    {
        $orders = SubOrder::where('order_state' , OrderTypes::Ready)->where('branch_id' , $branchID)->get();
        return OrderResource::collection($orders);
    }

    public function newOrders()
    {
        $orders = SubOrder::where('order_state' , OrderTypes::New)->get();
        return OrderResource::collection($orders);
    }
    public function newOrdersByBranch($branchID)
    {
        $orders = SubOrder::where('order_state' , OrderTypes::New)->where('branch_id' , $branchID)->get();
        return OrderResource::collection($orders);
    }


    public function waitingOrders()
    {
        $orders = SubOrder::where('order_state' , OrderTypes::WAITING)->get();
        return OrderResource::collection($orders);
    }
    public function waitingOrdersByBranch($branchID)
    {
        $orders = SubOrder::where('order_state' , OrderTypes::WAITING)->where('branch_id' , $branchID)->get();
        return OrderResource::collection($orders);
    }

    public function preparingOrders()
    {
        $orders = SubOrder::where('order_state' , OrderTypes::Preparing)->get();
        return OrderResource::collection($orders);
    }
    public function preparingOrdersByBranch($branchID)
    {
        $orders = SubOrder::where('order_state' , OrderTypes::Preparing)->where('branch_id' , $branchID)->get();
        return OrderResource::collection($orders);
    }

    public function pastOrders(){
        $orders = Order::whereHas('subOrders' , fn($query) =>
            $query->where('order_state' , OrderTypes::Ready)
        )->get();
        return PasOrderResource::collection($orders);
    }

    public function pastOrdersByBranch ($branchID)
    {
        $orders = Order::whereHas('subOrders' , fn($query) =>
        $query->where('order_state' , OrderTypes::Ready)
        )->where('branch_id' , $branchID)->get();
        return PasOrderResource::collection($orders);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubOrder $subOrder)
    {
        return OrderResource::make($subOrder);
    }

    public function toReady(SubOrder $subOrder)
    {

        $subOrder->update([
            'order_state' => OrderTypes::Ready
        ]);

        // then broadcast this ready order in readyOrder Channel
        $data = OrderResource::collection([$subOrder]);
        event(new ReadyToDeliverEvent($data));

        // but in casher we need to broadcast the parent order of this sub order with all sub orders that have state ready

        // so first : get the parent of this sub order

        $parent = Order::where('id' , $subOrder['order_id'])->first();

        $parent->update([
           'total' =>  $parent['total'] + $subOrder['total']
        ]);

        event(new PastOrdersEvent(PasOrderResource::make($parent)));

        $createdTime = $subOrder->created_at;

        $now = Carbon::now();

        $elapsed = $now->diffInMinutes($createdTime);

        $estimatedTime = Carbon::parse($subOrder->estimated_time);
        // Extract hours, minutes, seconds
        $hours = (int)$estimatedTime->format('H');
        $minutes = (int)$estimatedTime->format('i');
        $seconds = (int)$estimatedTime->format('s');

        // Convert to total minutes
        $estimatedMinutes = ($hours * 60) + $minutes + ($seconds / 60);

        $takingTime = $elapsed - $estimatedMinutes ;

        if($takingTime > 0){
            $carbon = Carbon::createFromTime(0, 0, 0);
            $carbon->addMinutes($takingTime);

            $timeString = $carbon->format('H:i:s');
            $subOrder->update([
               'delay_time' =>  $timeString
            ]);
        }

        if($takingTime < 0){
            $carbon = Carbon::createFromTime(0, 0, 0);
            $carbon->addMinutes($takingTime);

            $timeString = $carbon->format('H:i:s');
            $subOrder->update([
                'early_time' =>  $timeString
            ]);
        }



        return $this->customResponse($subOrder , 'your request was successfully and you order is ready now');
    }

    public function startPreparing(SubOrder $subOrder)
    {

        $subOrder->update([
            'order_state' => OrderTypes::Preparing
        ]);


        $data = OrderResource::collection([$subOrder]);
        event(new OnGoingOrderEvent($data));

        return $this->customResponse($subOrder,"Order's State Updated Successfully");
    }

    public function acceptOrder(SubOrder $subOrder)
    {

        $subOrder->update([
            'order_state' => OrderTypes::New
        ]);



        $data = OrderResource::collection([$subOrder]);

        event(new AddNewOrderEvent($data));

        return $this->success($subOrder,"Order's State Updated Successfully");
    }

    public function order_review(OrderReviewRequest $request , Order $order)
    {
        $order->update([
            'order_rate' => $request->order_rate,
            'service_rate' => $request->service_rate,
            'feedback' => $request->feedback
        ]);
        return $this->success($order,"Order rated Successfully");
    }
    public function calculateAverages()
    {
        $orders = Order::get();

        if ($orders->count() > 0){
            $totalOrderRate = 0;
            $totalServiceRate = 0;

            foreach ($orders as $order) {
                $totalOrderRate += $order->order_rate;
                $totalServiceRate += $order->service_rate;
            }

            $avgOrderRate = $totalOrderRate / $orders->count();
            $avgServiceRate = $totalServiceRate / $orders->count();

            return [
                'avgOrderRate' => $avgOrderRate,
                'avgServiceRate' => $avgServiceRate
            ];
        }

        return response([
            'avgOrderRate' => 0,
            'avgServiceRate' => 0
        ]);
    }

    public function calculateDelays(){
        $totalDelaySeconds = SubOrder::where('order_state' , OrderTypes::Ready)->selectRaw("SUM(TIME_TO_SEC(delay_time)) AS total_delay")
            ->first()
            ->total_delay;

        $avgDelaySeconds = 0;
        $avgDelayPercent = 0;
        $avgDelayTime = 0;
        if ($totalDelaySeconds > 0){
            $avgDelaySeconds = SubOrder::where('order_state' , OrderTypes::Ready)->selectRaw('AVG(TIME_TO_SEC(delay_time)) as avg_delay')
                ->first()
                ->avg_delay;
            $avgDelayPercent = ($avgDelaySeconds / $totalDelaySeconds) * 100;
            $avgDelayPercent = number_format($avgDelayPercent, 2);
            $avgDelayTime = date('H:i:s', $avgDelaySeconds);
        }

        $totalEarlySeconds = SubOrder::where('order_state' , OrderTypes::Ready)->selectRaw("SUM(TIME_TO_SEC(early_time)) AS total_early")
            ->first()
            ->total_early;
        $avgEarlyTime = 0;
        $avgEarlyPercent = 0;
        if ($totalEarlySeconds > 0){
            $avgEarlySeconds = SubOrder::where('order_state' , OrderTypes::Ready)->selectRaw('AVG(TIME_TO_SEC(early_time)) as avg_early')
                ->first()
                ->avg_early;
            $avgEarlyTime = date('H:i:s', $avgEarlySeconds);
            $avgEarlyPercent = ($avgEarlySeconds / $totalEarlySeconds) * 100;
            $avgEarlyPercent = number_format($avgEarlyPercent, 2);
        }
        return response([
            'avgDelayTime' => $avgDelayTime,
            'avgEarlyTime' => $avgEarlyTime,
            'avgDelayPercent' => $avgDelayPercent,
            'avgEarlyPercent' => $avgEarlyPercent
        ] , 200);
    }

    public static function lastfiveorder() {
        $orders = Order::latest()->take(5)->get();
        return $orders;
    }
}
