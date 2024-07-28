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
            'payment' => $this->payment,
            'tickets_price' => $this->tickets_price,
            'tickets_number' => $this->tickets_number,
            'event_name' => $this->publicEvent->name,
            'event_date' => $this->publicEvent->reservation->start_date,
            'event_start_time' => $this->publicEvent->reservation->time->start_time,
            'event_end_time' => $this->publicEvent->reservation->time->end_time,
        ];
    }
}
