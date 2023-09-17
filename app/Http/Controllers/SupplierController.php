<?php

namespace App\Http\Controllers;

use App\CustomResponse\ApiResponse;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\StoreSupplyRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Branch;
use App\Models\Ingredient;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\BranchSupplier;
use App\Models\IngredientSupplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    use ApiResponse;
    public function indexAll(){
        $suppliers = Supplier::all();
        return SupplierResource::collection($suppliers);
    }

    public function index($branchID){
        $branch = Branch::where('id' , $branchID)->first();
        if(!$branch){
            return $this->error('This Branch Not Found In Our System' , 404);
        }
        $suppliers = Supplier::whereHas('brancheSupplier', fn($query) =>
            $query->where('branch_id' , $branchID)
        )->get();
        return SupplierResource::collection($suppliers);
    }

    public function store(StoreSupplierRequest $request){
        $request->validated($request->all());
        $supplier = Supplier::create($request->all());
        return SupplierResource::make($supplier);
    }

    public function supply(StoreSupplyRequest $request)
    {
        $request->validated($request->all());

        foreach ($request->ingredients as $ingredient){
            $total_price = $ingredient->unit_price * $ingredient->come_in_quantity;
            IngredientSupplier::create([
               'supplier_id' =>  $request->supplier_id ,
                'ingredient_id' => $ingredient->ingredient_id,
                'come_in_quantity' => $ingredient->come_in_quantity,
                'unit_price' => $ingredient->unit_price,
                'unit' => $ingredient->unit,
                'total' => $total_price
            ]);
            $currentIngredient = Ingredient::where('id' , $ingredient->ingredient_id)->first();
            $currentIngredient->update([
                'quantity' => $currentIngredient->quantity + $ingredient->come_in_quantity
            ]);
        }
        return $this->success(null , 'successfully');
    }

    public function update(UpdateSupplierRequest $request , Supplier $supplier){
        $request->validated($request->all());
        $supplier->update($request->all());
        return SupplierResource::make($supplier);
    }

    public function show(Supplier $supplier) {
        // if (Checker::isParamsFoundInRequest()){
        //     return Checker::CheckerResponse();
        // }
        return SupplierResource::make($supplier);
}


    public function destroy(Supplier $supplier){
        $supplier->delete();
        return $this->success($supplier , 'Supplier Deleted Successfully From Our System');
    }
}
