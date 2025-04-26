<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class AuthResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'photo' => $this->photo_path ? URL::route('storage', ['path' => $this->photo_path, 'w' => 60, 'h' => 60, 'fit' => 'crop']) : null,
        ];
    }
}
