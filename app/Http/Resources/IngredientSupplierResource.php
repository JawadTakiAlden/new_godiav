<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IngredientSupplierResource extends JsonResource
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
            'supplier_id' => $this->supplier_id,
            'ingredient_id' => $this->ingredient_id,
            'branch_id' => $this->branch_id,
            'come_in_quantity' => $this->come_in_quantity,
            'unit' => $this->unit,
            'total_price' => $this->total_price,
            'relationships' => [
                'supplier' => $this->supplier,
                'ingredient' => $this->ingredient
            ]
        ];
    }
}
