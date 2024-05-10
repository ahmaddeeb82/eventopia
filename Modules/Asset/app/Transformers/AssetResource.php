<?php

namespace Modules\Asset\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Event\Transformers\GetServiceResource;

class AssetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return array_merge([
            'id' => $this->id,
            "photos" => json_decode($this->photos),
            "rate" => $this->rate,
            "services" => GetServiceResource::collection($this->services),
        ],$this->hall?(new HallResource($this->hall))->toArray($request):[]);
    }
}
