<?php

namespace Modules\Asset\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HallResourceWithTwoNames extends JsonResource
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
            "active_times" => TimeResource::collection($this->asset->times),
            "ar_name" => $this->getTranslations('name',['ar'])['ar'],
            "en_name" => $this->getTranslations('name', ['en'])['en'],
        ];
    }
}
