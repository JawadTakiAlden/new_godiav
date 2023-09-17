<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image' => $this->image,
            'name' => $this->name,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'calories' => $this->calories,
            'price' => $this->price,
            'relationships' => [
                'category' => $this->category,
                'ingredients' => $this->ingredientProduct,
                'branch' => $this->branch
            ]
        ];
    }
}
