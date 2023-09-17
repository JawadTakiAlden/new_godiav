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

    public function ingredients(){
        return $this->hasMany(Ingredient::class);
    }

    public function branchSupplier(){
        return $this->belongsToMany(BranchSupplier::class);
    }

    public function employees(){
        return $this->hasMany(Employee::class);
    }
}
