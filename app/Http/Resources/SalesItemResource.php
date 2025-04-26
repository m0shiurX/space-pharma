<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SalesItemResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'medicine_id' => $this->medicine_id,
            'medicine_name' => $this->medicine->name,
            'batch_id' => $this->batch_id,
            'quantity' => $this->quantity,
            'selling_price' => $this->selling_price,
            'discount' => $this->discount,
            'total_price' => $this->total_price,
        ];
    }
}
