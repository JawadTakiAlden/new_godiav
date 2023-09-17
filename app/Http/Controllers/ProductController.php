<?php

namespace App\Http\Controllers;

use App\CustomResponse\ApiResponse;
use App\Http\Requests\StoreProudectRequest;
use App\Http\Requests\UpdateProductRequst;
use App\Http\Resources\ProductResource;
use App\Models\Branch;
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

    public function store(StoreProudectRequest $requst) {
        $requst->validated($requst->all());
        $product = Product::create($requst->all());
        return ProductResource::make($product);
    }

    public function update(UpdateProductRequst $requst, Product $product) {
        $requst->validated($requst->all());
        $product->update($requst->all());
        return ProductResource::make($product);
    }

    public function show($branchID , Product $product) {
        $branch = Branch::where('id' , $branchID)->first();
        if(!$branch){
            return $this->error('This Branch Not Found In Our System' , 404);
        }
        $products = Product::where('branch_id', $branchID)->get();
        // if (Checker::isParamsFoundInRequest()){
        //     return Checker::CheckerResponse();
        // }
        return ProductResource::make($product);
}

    public function destroy(Product $product){
        $product->delete();
        return $this->success($product,'Product Deleted Successfully From Our System');
    }
}
