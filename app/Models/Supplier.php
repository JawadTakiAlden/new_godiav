<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function ingredients () {
        return $this->hasMany(Ingredient::class);
    }

    public function setImageAttribute ($image){
        $newImageName = uniqid() . '_' . 'supplier_image' . '.' . $image->extension();
        $image->move(public_path('supplier_images') , $newImageName);
        return $this->attributes['image'] =  '/'.'supplier_images'.'/' . $newImageName;
    }

    public function brancheSupplier(){
        return $this->hasMany(BranchSupplier::class);
    }
}
