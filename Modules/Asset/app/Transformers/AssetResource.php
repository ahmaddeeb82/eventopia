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
            "services" => isset(auth()->user()->assets[0]) && count(auth()->user()->assets[0]->serviceAssets)!=0?GetServiceWithPriceResource::collection(auth()->user()->assets[0]->servicesWithPrice->unique('id')->all()):[],
            "is_favorite" => auth()->user()->favoriteAssets()->where('favoritable_id', $this->id)->first() != null?true:false,
        ],$this->hall?(new HallResource($this->hall))->toArray($request):['start_time' => $this->times->first()->start_time, 'end_time' => $this->times()->first()->end_time]);
    }
}
