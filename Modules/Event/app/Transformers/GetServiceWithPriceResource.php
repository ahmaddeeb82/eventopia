<?php

namespace Modules\Event\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Event\Models\ServiceAsset;

class GetServiceWithPriceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        //$serviceAsset = ServiceAsset::where('asset_id', $this->pivot->asset_id)->where('service_id', $this->pivot->service_id)->first();
        return [
            'id' => $this->id,
            'name' => $this->service->name,
            'kind' => $this->service->kind,
            'price' => $this->price,
            'discounted_price' => $this->discounts()->first()?$this->discounts()->first()->disconted_price:null,
            'proportion' => $this->proportion?$this->proportion->proportion:null,
        ];
    }
}
