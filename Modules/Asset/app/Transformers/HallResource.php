<?php

namespace Modules\Asset\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HallResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "capacity" => $this->capacity,
            "dinner" => $this->dinner,
            "dinner_price" => $this->dinner_price,
            "mixed" => $this->mixed,
            "address" => $this->address,
            "mixed_price" => $this->mixed_price,
            "active_times" => TimeResource::collection($this->times),
            "name" => $this->name,
        ];
    }
}
