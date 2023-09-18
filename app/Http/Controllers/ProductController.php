<?php

namespace App\Http\Controllers;

use App\CustomResponse\ApiResponse;
use App\Http\Requests\StoreProudectRequest;
use App\Http\Requests\UpdateProductRequst;
use App\Http\Resources\ProductResource;
use App\Models\Branch;
use App\Models\IngredientProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponse;
    public function index($branchID) {
        $branch = Branch::where('id' , $branchID)->first();
        if(!$branch){
            return $this->error('This Branch Not Found In Our System' , 404);
        }
        $products = Product::where('branch_id', $branchID)->get();
        return ProductResource::collection($products);
    }

    public function store(StoreProudectRequest $request) {
        $request->validated($request->all());
        $product = Product::create($request->all());

        foreach ($request->ingredient_ids as $ingredient_id){
            IngredientProduct::create([
               'ingredient_id' =>  $ingredient_id ,
                'product_id' => $product->id
            ]);
        }
        return ProductResource::make($product);
    }

    public function update(UpdateProductRequst $request, Product $product) {
        $request->validated($request->all());
        $product->update($request->all());
        return ProductResource::make($product);
    }

    public function show(Product $product) {
        return ProductResource::make($product);
}

    public function destroy(Product $product){
        $product->delete();
        return $this->success($product,'Product Deleted Successfully From Our System');
    }

    public function lastfiveproduct() {
        $products = Product::latest()->take(5)->get();
        return response()->json($products);
    }
}
