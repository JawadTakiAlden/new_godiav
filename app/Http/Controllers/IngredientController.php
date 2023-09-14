<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreIngredientsRequst;
use App\Http\Requests\UpdateingredientsRequest;
use App\Http\Resources\IngredientResource;
use App\CustomResponse\ApiResponse;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    use ApiResponse;
    public function index() {
        $ingredient = Ingredient::all();
        return $ingredient;
    }

    public function store(StoreIngredientsRequst $requst) {
        $requst->validated($requst->all());
        $ingredient = Ingredient::create($requst->all());
        return IngredientResource::make($ingredient);
    }

    public function update(UpdateingredientsRequest $requst, Ingredient $ingredient) {
        $requst->validated($requst->all());
        $ingredient->update($requst->all());
        return IngredientResource::make($ingredient);
    }
    public function show(Ingredient $ingredient) {
            // if (Checker::isParamsFoundInRequest()){
            //     return Checker::CheckerResponse();
            // }
            return IngredientResource::make($ingredient);
    }
    

    public function delete(Ingredient $ingredient){
        $ingredient->delete();
        return $this->success($ingredient,'ingredient Deleted Successfully From Our System');
    }
}
