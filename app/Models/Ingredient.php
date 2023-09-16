<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function suppliers(){
        return $this->belongsToMany(Supplier::class);
    }

    public function products() {
        return $this->belongsToMany(Product::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }
}
