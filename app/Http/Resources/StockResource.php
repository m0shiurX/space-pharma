<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'batch_id' => $this->batch_id,
            'expiry_date' => Carbon::parse($this->expiry_date)->format('d-m-Y'),
            'stock' => $this->stock
        ];
    }
}
