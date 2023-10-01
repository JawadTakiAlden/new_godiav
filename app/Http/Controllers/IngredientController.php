<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreIngredientsRequst;
use App\Http\Requests\UpdateingredientsRequest;
use App\Http\Resources\IngredientResource;
use App\Models\Branch;
use App\CustomResponse\ApiResponse;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    use ApiResponse;
    public function index() {
        $ingredient = Ingredient::all();
        return IngredientResource::collection($ingredient);
    }

    public function indexByBranch($branchID)
    {
        $branch = Branch::where('id' , $branchID)->first();

        if(!$branch){
            return $this->error('Requested Branch Not Found' , 404);
        }

        $ingredients = Ingredient::where('branch_id' , $branchID)->get();

        return IngredientResource::collection($ingredients);
    }

    public function store(StoreIngredientsRequst $request) {
        $request->validated($request->all());
        $ingredient = Ingredient::create($request->all());
        return IngredientResource::make($ingredient);
    }

    public function update(UpdateingredientsRequest $request, Ingredient $ingredient) {
        $request->validated($request->all());
        $ingredient->update($request->all());
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

    public function last5($branchID)
    {
        $branch = Branch::where('id', $branchID)->first();
        if (!$branch) {
            return $this->error('This Branch Not Found In Our System', 404);
        }
        $ingredients = Ingredient::where('branchID', $branchID)->latest()->take(5)->get();
        return IngredientResource::collection($ingredients);
    }
}
