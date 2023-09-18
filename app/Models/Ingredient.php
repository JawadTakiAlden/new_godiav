<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function ingredientSupplier(){
        return $this->belongsToMany(IngredientSupplier::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function ingredientProduct() {
        return $this->hasMany(IngredientProduct::class);
    }
}
