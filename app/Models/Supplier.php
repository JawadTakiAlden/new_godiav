<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class Supplier extends Authenticatable
{
    use HasFactory , HasApiTokens;
    protected $guarded = ['id'];
    protected $guard = 'supplier';

    protected $hidden = [
        'password',
    ];
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
    public function ingredients ()
    {
        return $this->hasMany(Ingredient::class);
    }

    public function setImageAttribute ($image)
    {
        $newImageName = uniqid() . '_' . 'supplier_image' . '.' . $image->extension();
        $image->move(public_path('supplier_images') , $newImageName);
        return $this->attributes['image'] =  '/'.'supplier_images'.'/' . $newImageName;
    }

    public function brancheSupplier()
    {
        return $this->hasMany(BranchSupplier::class);
    }
}
