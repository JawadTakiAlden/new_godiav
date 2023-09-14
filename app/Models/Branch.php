<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function categories () {
        return $this->hasMany(Category::class);
    }

    public function products () {
        return $this->hasMany(Product::class);
    }

    public function suppliers(){
        return $this->belongsToMany(Supplier::class);
    }
}
