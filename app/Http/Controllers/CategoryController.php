<?php

namespace App\Http\Controllers;

use App\CustomResponse\ApiResponse;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Branch;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function indexall()
    {
        // if (Checker::isParamsFoundInRequest()){
        //     return Checker::CheckerResponse();
        // }
        $categories = Category::where('visibility' , true)->get();

        return CategoryResource::collection($categories);
    }

    public function index($branchID){
        $branch = Branch::where('id' , $branchID)->first();
        if(!$branch){
            return $this->error('This Branch Not Found In Our System' , 404);
        }
        $suppliers = Category::where('branch_id', $branchID)->get();
        return $suppliers;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        // if (Checker::isParamsFoundInRequest()){
        //     return Checker::CheckerResponse();
        // }

        $request->validated($request->all());

        $category = Category::create($request->all());

        return CategoryResource::make($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        // if (Checker::isParamsFoundInRequest()){
        //     return Checker::CheckerResponse();
        // }
        return CategoryResource::make($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        // if (Checker::isParamsFoundInRequest()){
        //     return Checker::CheckerResponse();
        // }
        $request->validated($request->all());

        $category->update($request->all());

        return CategoryResource::make($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // if (Checker::isParamsFoundInRequest()){
        //     return Checker::CheckerResponse();
        // }
        $category->delete();

        return $this->success($category , 'One Category Deleted Successfully');
    }

    public function switchCategory(Category $category){
        // if (Checker::isParamsFoundInRequest()){
        //     return Checker::CheckerResponse();
        // }
        $category->update([
            'visibility' => ! boolval($category->visibility),
        ]);

        return CategoryResource::make($category);
    }
}
