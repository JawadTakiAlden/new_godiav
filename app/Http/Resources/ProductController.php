<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductController extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image' => $this->image,
            'name' => $this->name,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'visibility' => $this->visibility,
            'calories' => $this->calories,
            'estimated_time' => $this->estimated_time,
            'craeted_at' => $this->craeted_at,
            'updated_at' => $this->updated_at,
        ];
    }

    
}
