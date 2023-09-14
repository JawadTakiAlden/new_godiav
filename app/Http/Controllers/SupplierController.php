<?php

namespace App\Http\Controllers;

use App\CustomResponse\ApiResponse;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    use ApiResponse;
    public function index(){
        $suppliers = Supplier::all();
        return SupplierResource::collection($suppliers);
    }

    public function store(StoreSupplierRequest $request){
        $request->validated($request->all());
        $supplier = Supplier::create($request->all());
        return SupplierResource::make($supplier);
    }

    public function update(UpdateSupplierRequest $request , Supplier $supplier){
        $request->validated($request->all());
        $supplier->update($request->all());
        return SupplierResource::make($supplier);
    }

    public function delete(Supplier $supplier){
        $supplier->delete();
        return $this->success($supplier , 'Supplier Deleted Successfully From Our System');
    }
}
