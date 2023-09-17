<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTableRequest;
use App\Http\Resources\TableResource;
use App\Models\Table;
use App\Models\User;
use App\Models\Order;
use GuzzleHttp\Promise\Create;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index() {
        // if (Checker::isParamsFoundInRequest()){
        //     return Checker::CheckerResponse();
        // }
        $tables = Table::all();

        return TableResource::collection($tables);
    }

    public function store(StoreTableRequest $request) {
        
        // if (Checker::isParamsFoundInRequest()){
        //     return Checker::CheckerResponse();
        // }
        $request->validated($request->all());

        $table = Table::create($request->all());

        return TableResource::collection([$table]);
    }

    public function show(Table $table) {

        // if (Checker::isParamsFoundInRequest()){
        //     return Checker::CheckerResponse();
        // }
        return TableResource::collection([$table]);
    }

    public function delete(User $user) {
        $user->delete();
        return $this->success($user , 'User Deleted Successfully From Our System');
    }

    
    // public function closeTable(Table $table){
    //     if (Checker::isParamsFoundInRequest()){
    //         return Checker::CheckerResponse();
    //     }
    //     $table->update([
    //        'in_progress' => false
    //     ]);


    //     $order = Order::where('table_id' , $table['id'])->where('in_progress' , true)->first();

    //     $order->update([
    //         'in_progress' => false
    //     ]);

    //     return $this->customResponse($table , 'Your request was successfully and table number' . $table['table_number'] . 'is free now');
    // }
}
