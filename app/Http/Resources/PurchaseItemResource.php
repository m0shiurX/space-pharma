<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'medicine_id' => $this->medicine_id,
            'medicine_name' => $this->medicine->name,
            'batch_id' => $this->batch_id,
            'quantity' => $this->quantity,
            'vat' => $this->vat,
            'purchase_price' => $this->purchase_price,
            'total_price' => $this->total_price,
        ];
    }
}
