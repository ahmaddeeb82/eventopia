<?php

namespace Modules\Discounts\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetDiscountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'asset_id' => $this->serviceAsset->asset->id,
            'event_id' => $this->serviceAsset->id,
            'discount_percentage' => $this->percentage,
            'name' => $this->serviceAsset->asset->hall?$this->serviceAsset->asset->hall->name:$this->serviceAsset->asset->user->first_name.' '. $this->serviceAsset->asset->user->last_name,
            'old_price' => $this->serviceAsset->price,
            'new_price' => $this->disconted_price,
        ];
    }
}
