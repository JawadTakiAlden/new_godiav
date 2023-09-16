<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function setImageAttribute ($image){
        $newImageName = uniqid() . '_' . 'employee_image' . '.' . $image->extension();
        $image->move(public_path('employee_images') , $newImageName);
        return $this->attributes['image'] =  '/'.'employee_images'.'/' . $newImageName;
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }
}
