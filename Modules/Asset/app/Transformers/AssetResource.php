<?php

namespace Modules\Asset\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Event\Transformers\GetServiceResource;
use Modules\Event\Transformers\GetServiceWithPriceResource;

class AssetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        // return [$this->services];
        return array_merge([
            'id' => $this->id,
            "photos" => json_decode($this->photos),
            "rate" => $this->rate,
            "services" => GetServiceWithPriceResource::collection($this->servicesWithPrice),
        ],$this->hall?(new HallResource($this->hall))->toArray($request):[]);
    }
}
