<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\TableResource;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\Product;
use App\Models\Table;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function getTops(){
        return response([
            'statistics' => $this->statistics()
        ]);
    }

    public function statistics(){
        $products = Product::count();
        $categories = Category::count();
        $orders = Order::count();
        $tables = Table::count();
        $ingredients = Ingredient::count();
        $totalSeals = Order::sum('total');
        return [
            'product_count' => $products,
            'category_count' =>  $categories ,
            'order_count' => $orders ,
            'table_count' => $tables,
            'ingredient_count' => $ingredients,
            'total_seals' => $totalSeals
        ];
    }
}
