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
        $serviceAsset = ServiceAsset::where('asset_id', $this->pivot->asset_id)->where('service_id', $this->pivot->service_id)->first();
        return [
            'id' => $serviceAsset->id,
            'name' => $this->name,
            'kind' => $this->kind,
            'price' => $this->pivot->price,
            'discounted_price' => $serviceAsset->discounts()->first()?$serviceAsset->discounts()->first()->disconted_price:null,
            'proportion' => $serviceAsset->proportion?$serviceAsset->proportion->proportion:null,
        ];
    }
}
