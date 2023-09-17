<?php

namespace App\Http\Controllers;

use App\CustomResponse\ApiResponse;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;

class EmployeeController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        return EmployeeResource::collection($employees);
    }

    public function indexByBranch($branchID)
    {
        $employees = Employee::where('branch_id' , $branchID)->get();


//        $employees = Employee::whereHas('branch' , fn($query) =>
//            $query->where('id' , $branchID)
//        );

        return EmployeeResource::collection($employees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $request->validated($request->all());

        $employee = Employee::create($request->all());

        return EmployeeResource::make($employee);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return EmployeeResource::make($employee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $request->validated($request->all());

        $employee->update($request->all());

        return EmployeeResource::make($employee);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return $this->success($employee , 'Employee Deleted Successfully From Our System');
    }
}
