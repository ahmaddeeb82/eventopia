<?php

namespace Modules\Reservation\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicEventTicketsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'ticket_id' => $this->id,
            "user_name" => $this->user->first_name . ' ' . $this->user->last_name,
            'payment' => $this->payment,
            'tickets_price' => $this->tickets_price,
            'tickets_number' => $this->tickets_number,
            'event_name' => $this->publicEvent->name,
            'event_date' => $this->publicEvent->reservation->start_date,
            'event_start_time' => $this->publicEvent->reservation->time()->withTrashed()->first()->start_time,
            'event_end_time' => $this->publicEvent->reservation->time()->withTrashed()->first()->end_time,
        ];
    }
}
