<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Authenticatable
{
    use HasFactory , HasApiTokens;
    protected $guarded = ['id'];
    protected $guard = 'employee';

    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
    public function setImageAttribute ($image){
        $newImageName = uniqid() . '_' . 'employee_image' . '.' . $image->extension();
        $image->move(public_path('employee_images') , $newImageName);
        return $this->attributes['image'] =  '/'.'employee_images'.'/' . $newImageName;
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }
}
