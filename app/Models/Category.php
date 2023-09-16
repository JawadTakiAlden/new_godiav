<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function setImageAttribute ($image){
        $newImageName = uniqid() . '_' . 'category_image' . '.' . $image->extension();
        $image->move(public_path('categories_images') , $newImageName);
        return $this->attributes['image'] =  '/'.'categories_images'.'/' . $newImageName;
    }


    public function products(){
        return $this->hasMany(Product::class);
    }
    public function branch(){
        return $this->belongsTo(Branch::class);
    }
}
