<?php

namespace App\Http\Controllers;

use App\CustomResponse\ApiResponse;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\StoreProudectRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Http\Resources\BranchResource;
use App\Models\Branch;
use App\Models\BranchSupplier;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    use ApiResponse;
    public function index()
    {
        $branch = Branch::all();
        return $branch;
    }


    public function store(StoreBranchRequest $request)
    {
        $request->validated($request->all());

        $branch = Branch::create($request->all());

        foreach (json_decode($request->supplier_ids) as $supplier_id){
            BranchSupplier::create([
                'branch_id' =>  $branch->id,
                'supplier_id' => $supplier_id
            ]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch) {
        // if (Checker::isParamsFoundInRequest()){
        //     return Checker::CheckerResponse();
        // }
        return BranchResource::make($branch);
}

    public function update(UpdateBranchRequest $requst, Branch $branch) {
        $requst->validated($requst->all());
        $branch->update($requst->all());
        return BranchResource::make($branch);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();
        return $this->success($branch , 'Branch Deleted Successfully From Our System');
    }
}
