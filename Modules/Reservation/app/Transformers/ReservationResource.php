<?php

namespace Modules\Reservation\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Asset\Transformers\HallResource;
use Modules\Event\Http\Requests\GetServiceRequest;
use Modules\Event\Models\ServiceAsset;
use Modules\Event\Transformers\GetServiceResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            
            'id' => $this -> id,
            'confirmed_guest_id' => $this->user->first_name.' '. $this->user->last_name,
            "attendees_number" => $this -> attendees_number,
            "start_date" => $this -> start_date,
            "end_date" => $this -> end_date,
            "duration" => $this -> duration,
            "event_id" => $this -> services -> name,
            "total_price" => $this -> total_price,
            "notes" => $this -> notes,

        ];
    }
}
