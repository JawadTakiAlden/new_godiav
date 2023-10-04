<?php

namespace App\Http\Controllers;

use App\CustomResponse\ApiResponse;
use App\Http\Requests\StoreTableRequest;
use App\Http\Resources\TableResource;
use App\Models\Branch;
use App\Models\Order;
use App\Models\Table;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;

class TableController extends Controller
{
    use ApiResponse;
    public function index() {
        $tables = Table::all();
        return TableResource::collection($tables);
    }


    public function indexByBranch($branchID)
    {
        $branch = Branch::where('id' , $branchID)->first();

        if(!$branch){
            return $this->error('Requested Branch Not Found' , 404);
        }

        $tables = Table::where('branch_id' , $branchID)->get();

        return TableResource::collection($tables);
    }

    public function store(StoreTableRequest $request)
    {
        $request->validated($request->all());

        $table = Table::create($request->all());

        return TableResource::make($table);
    }

    public function show(Table $table) {

        // if (Checker::isParamsFoundInRequest()){
        //     return Checker::CheckerResponse();
        // }
        return TableResource::make($table);
    }

    public function delete(Table $table) {
        $table->delete();
        return $this->success($table , 'Table Deleted Successfully From Our System');
    }


     public function closeTable(Table $table){
         $table->update([
            'in_progress' => false
         ]);
         $order = Order::where('table_id' , $table['id'])->where('in_progress' , true)->first();
         $order->update([
             'in_progress' => false
         ]);
         return $this->success($table , 'Your request was successfully and table number' . $table['table_number'] . 'is free now');
     }

     public function available_table(){
        $table = Table::where('in_progress', false)->get();
        return TableResource::collection($table);
     }

    public function not_available($branchID){
        $branch = Branch::where('id', $branchID)->first();
        if(!$branch){
            return $this->error('This Branch Not Found In Our System' , 404);
        }
        $table = Table::where('in_progress', true)->get();
        return TableResource::collection($table);
     }
}
