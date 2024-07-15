<?php

namespace Modules\Asset\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Event\Transformers\GetServiceResource;
use Modules\Event\Transformers\GetServiceWithPriceResource;

class AssetResourceWithTwoNames extends JsonResource
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
            "is_favorite" => auth()->user()->favoriteAssets()->where('favoritable_id', $this->id)->first() != null?true:false,
        ],$this->hall?(new HallResourceWithTwoNames($this->hall))->toArray($request):['start_time' => $this->times->first()->start_time, 'end_time' => $this->times()->first()->end_time]);
    }
}
