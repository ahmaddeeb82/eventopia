<?php

namespace Modules\Contracts\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetContractsWithUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'owner_name' => $this->user->first_name . ' ' . $this->user->last_name,
            'owner_address' => $this->user->address,
            'owner_phone' => $this->user->phone_number,
            'price' => $this->price,
            'duration' => $this->duration,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'active' => !$this->trashed(),
        ];
    }
}
