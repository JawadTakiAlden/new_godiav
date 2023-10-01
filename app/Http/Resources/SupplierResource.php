<?php

namespace App\Http\Resources;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'father_name' => $this->father_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'image' => $this->image,
            'relationship' => [
                'branches' => BranchResource::collection(Branch::whereHas('branchSupplier' , fn($query) =>
                    $query->where('supplier_id' , $this->id)
                )->get())
            ]

        ];
    }
}
