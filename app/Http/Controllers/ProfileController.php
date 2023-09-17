<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Http\Resources\SupplierResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function userProfile()
    {
        return UserResource::make(Auth::user());
    }
    public function employeeProfile()
    {
        return EmployeeResource::make(Auth::guard()->user());
    }
    public function supplierProfile()
    {
        return SupplierResource::make(Auth::guard()->user());
    }
}
