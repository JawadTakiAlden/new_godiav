<?php

namespace App\Http\Controllers;

use App\CustomResponse\ApiResponse;
use App\Http\Requests\LoginEmployeeRequest;
use App\Http\Requests\LoginSupplierRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\SupplierResource;
use App\Http\Resources\UserResource;
use App\Models\Employee;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    use ApiResponse;
    public function login(LoginUserRequest $request){
        try {
//            if (Checker::isParamsFoundInRequest()){
//                return Checker::CheckerResponse();
//            }
            // validate data coming by request
            $request->validated($request->all());

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return $this->error('Your Make A Mistake With your Password' , 401);
            }

            $user = User::where('email', $request->email)->first();
            $userAuth = auth()->user();


            return $this->success([
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'user' => UserResource::make($userAuth),
            ], 'User Login Successfully');

        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function loginEmployee(LoginEmployeeRequest $request)
    {
        try {
            $request->validated($request->all());

            if (!Auth::guard('employee')->attempt($request->only(['serial_number', 'password']))) {
                return $this->error('Your Make A Mistake With your Password' , 401);
            }

            $employee = Employee::where('serial_number', $request->serial_number)->first();
            $employeeAuth = Auth::guard('employee')->user();


            return $this->success([
                'token' => $employee->createToken("API TOKEN")->plainTextToken,
                'employee' => EmployeeResource::make($employeeAuth),
            ], 'Employee Login Successfully');

        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function loginSupplier(LoginSupplierRequest $request)
    {
        try {
            $request->validated($request->all());

            if (!Auth::guard('supplier')->attempt($request->only(['email', 'password']))) {
                return $this->error('Your Make A Mistake With your Password' , 401);
            }

            $supplier = Supplier::where('email', $request->email)->first();
            $supplierAuth = Auth::guard('supplier')->user();


            return $this->success([
                'token' => $supplier->createToken("API TOKEN")->plainTextToken,
                'supplier' => SupplierResource::make($supplierAuth),
            ], 'User Login Successfully');

        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
