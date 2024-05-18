<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetInvestorsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->first_name . ' ' . $this->last_name,
        ],$this->hasRole('HallOwner')?['halls' => $this->assets()->count(),]:[]);
    }
}
