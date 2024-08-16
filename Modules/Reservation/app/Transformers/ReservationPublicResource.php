<?php

namespace Modules\Reservation\Transformers;

use Illuminate\Http\Request;
use Modules\Reservation\Models\Reservation;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationPublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    
    public function toArray(Request $request): array
    {
        return [
            'category' => $this -> category()->withTrashed()->first() -> name,
            'description' => $this -> description,
            'photo' => $this -> photo,
            'name' => $this -> name,
            'address' => $this -> address,
            'ticket_price' => $this -> ticket_price,
            "is_favorite" => auth()->user()->favoritePublicEvents()->where('favoritable_id', $this->id)->first() != null?true:false,
        ];
    }
}
