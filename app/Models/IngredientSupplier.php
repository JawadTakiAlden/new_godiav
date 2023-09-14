<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientSupplier extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function ingredient(){
        return $this->belongsTo(Ingredient::class);
    }
}
