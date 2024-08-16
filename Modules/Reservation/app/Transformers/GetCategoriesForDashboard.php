<?php

namespace Modules\Reservation\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetCategoriesForDashboard extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ar_name' => $this->getTranslations('name',['ar'])['ar'],
            'en_name' => $this->getTranslations('name',['en'])['en'],
        ];
    }
}
