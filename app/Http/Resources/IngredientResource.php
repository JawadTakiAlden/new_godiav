<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IngredientResource extends JsonResource
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
            'name' => $this->name,
            'quantity' => $this->quantity,
            'should_notify_quantity' => $this->should_notify_quantity,
            'base_unit' => $this->base_unit,
            'relationship' => [
            'branch' => $this->branch
            ]
        ];
    }
}
