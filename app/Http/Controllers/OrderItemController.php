<?php

namespace App\Http\Controllers;


use App\CustomResponse\ApiResponse;
use App\Events\AddWaitingOrderEvent;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Ingredient;
use App\Models\IngredientProduct;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SubOrder;
use App\Models\Table;
use Illuminate\Support\Carbon;

class OrderItemController extends Controller
{
    use ApiResponse;
    public function store(StoreOrderRequest $request)
    {

        $request->validated($request->all());

        // get table that we want to add order on it
        $table = Table::where('id' , $request->get('table_id'))->first();

        // then check if this table has customer on it
        if ($table['in_progress']){

            // so we want to get in progress order for this table
            $order = Order::where('table_id' , $table['id'])
                ->where('in_progress' , true)
                ->first();
            // then create new sub order and make it refer to table's order
            $subOrder = SubOrder::create([
                'order_id' => $order['id'],
                'table_id' => $table['id'],
            ]);

            // now we need to update total price for this sub order by loop over order items
            $total_price_of_sub_order = 0;
            $estimatedTime = 0;

            // get order items for this sub order
            foreach ($request->order_items as $order_item){

                $product = Product::where('id' , $order_item['product_id'])->first();

                // $productIngredients = IngredientProduct::where('product_id' , );

                // get estimated time for this order_item
                $curentItemEstimatedTime = $product['estimated_time'];
                if ( $estimatedTime < $curentItemEstimatedTime ){
                    $estimatedTime = $curentItemEstimatedTime;
                }
                // calc total price of this order ite,
                $total_price_of_item = $order_item['quantity'] * $product->price;
                // initilize array of order item data
                $order_item_data = array_merge($order_item , ['sub_order_id' => $subOrder['id'] , 'total' => $total_price_of_item]);
                OrderItem::create($order_item_data);

                // update total price of sub order
                $total_price_of_sub_order += $total_price_of_item;
            }


            $subOrder->update([
                'total' => $total_price_of_sub_order,
                'estimated_time' => $estimatedTime
            ]);

            return OrderResource::make($subOrder);
        }else {

            // if table wasn't in progress and new order on it , then we need to switch it to in progress
            $table->update([
               'in_progress' => true
            ]);

            $newOrder = Order::create([
               'table_id' => $table->id
            ]);

            $subOrder = SubOrder::create([
                'order_id' => $newOrder['id'],
                'table_id' => $table['id'],
            ]);

            $total_price_of_sub_order = 0;
            $estimatedTime = 0;
            // get order items for this sub order

            foreach ($request->order_items as $order_item){
                // then get meal that this order item has it
                $product = Product::where('id' , $order_item['product_id'])->first();
                // get estimated time for this order_item
                $curentItemEstimatedTime = $product['estimated_time'];
                $estimatedTime = max($estimatedTime , $curentItemEstimatedTime);
                // calc total price of this order ite,
                $total_price_of_item = $order_item['quantity'] * $product->price;
                // initilize array of order item data
                $order_item_data = array_merge($order_item , ['sub_order_id' => $subOrder['id'] , 'total' => $total_price_of_item]);
                OrderItem::create($order_item_data);

                // update total price of sub order
                $total_price_of_sub_order += $total_price_of_item;
            }


            $subOrder->update([
                'total' => $total_price_of_sub_order,
                'estimated_time' => $estimatedTime
            ]);

            return OrderResource::make($subOrder);
        }
    }
}
