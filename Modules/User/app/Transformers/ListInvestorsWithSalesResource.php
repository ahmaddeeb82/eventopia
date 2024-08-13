<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListInvestorsWithSalesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name' => $this->first_name . ' ' . $this->last_name,
            'role' => $this->role,
            'sales' => $this->total_reservation_price,
        ];
    }
}
