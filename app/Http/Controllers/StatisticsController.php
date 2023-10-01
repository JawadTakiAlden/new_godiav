<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\TableResource;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Table;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function getTops($branchID){
        $branch = Branch::where('id', $branchID)->first();
        if(!$branch){
            return $this->error('This Branch Not Found In Our System' , 404);
        }
        return response([
            'statistics' => $this->statistics($branchID)
        ]);
    }

    public function statistics($branchID){
        $products = Product::where('branch_id' , $branchID)->count();
        $categories = Category::where('branch_id' , $branchID)->count();
        $orders = Order::where('branch_id' , $branchID)->count();
        $tables = Table::where('branch_id' , $branchID)->count();
        $ingredients = Ingredient::where('branch_id' , $branchID)->count();
        $totalSeals = Order::where('branch_id' , $branchID)->sum('total');
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
