<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\TableResource;
use App\Models\Product;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function getTops(){
        $products = ProductController::lastfiveproduct();
        $categories = CategoryController::lastfivecategory();
        $tables = TableController::not_available();
        return response([
           'last_products' =>  ProductResource::collection($products),
            'last_categories' => CategoryResource::collection($categories),
            'busy_tables' => TableResource::collection($tables)
        ]);
    }
}
