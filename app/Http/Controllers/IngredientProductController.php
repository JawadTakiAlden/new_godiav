<?php

namespace App\Http\Controllers;

use App\CustomResponse\ApiResponse;
use App\Http\Requests\UpdateIngredientProductRequest;
use App\Models\IngredientProduct;
use Illuminate\Http\Request;

class IngredientProductController extends Controller
{
    use ApiResponse;
    public function destroy(IngredientProduct $ingredientProduct){
        $ingredientProduct->delete();
        return $this->success(null , 'deleted successfully');
    }

    public function update(UpdateIngredientProductRequest $request , IngredientProduct $ingredientProduct){
        $request->validated($request->all());
        $ingredientProduct->update($request->all());
        return $this->success(null , 'updated successfully');
    }
}
