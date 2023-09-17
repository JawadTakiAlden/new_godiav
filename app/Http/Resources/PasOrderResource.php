<?php

namespace App\Http\Resources;

use App\Status\OrderStatus;
use App\Types\OrderTypes;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PasOrderResource extends JsonResource
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
            'table_id' => $this->table_id,
            'in_progress' => $this->in_progress,
            'total' => $this->total,
            'order_rate' => $this->order_rate,
            'service_rate' => $this->service_rate,
            'feedback' => $this->feedback,
            'relationships' => [
                'table' => $this->table,
                'ready_sub_orders' => OrderResource::collection($this->subOrders->filter(function ($subOrder) {
                    return $subOrder->order_state === OrderTypes::Ready;
                }))
            ]
        ];
    }
}
