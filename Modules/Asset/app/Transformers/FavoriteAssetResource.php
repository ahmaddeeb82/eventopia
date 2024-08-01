<?php

namespace Modules\Asset\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Event\Transformers\GetServiceWithPriceResource;

class FavoriteAssetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return array_merge([
            'id' => $this->id,
            'pivot_id' =>$this->pivot->id,
            "photos" => json_decode($this->photos),
            "rate" => $this->rate,
            "services" => GetServiceWithPriceResource::collection($this->serviceAssets),
        ],$this->hall?(new HallResource($this->hall))->toArray($request):[
            'start_time' => $this->times->first()->start_time,
            'end_time' => $this->times()->first()->end_time,
            'organizer_name' => $this->user->first_name . ' ' . $this->user->last_name,
        ]);
    }
}
