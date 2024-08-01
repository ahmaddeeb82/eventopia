<?php

namespace Modules\Reservation\Transformers;

use Illuminate\Http\Request;
use Modules\Reservation\Models\Reservation;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationPrivateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {  
        //$reservation = Reservation::with('services')->find($request['id']);
              
        return array_merge([
            'id' => $this -> id,
            'confirmed_guest_id' => $this->user->first_name.' '. $this->user->last_name,
            'attendees_number' => $this -> attendees_number,
            'start_date' => $this -> start_date,
            'end_date' => $this -> end_date,
            'start_time' => $this->time()->withTrashed()->first()->start_time,
            'end_time' => $this->time()->withTrashed()->first()-> end_time,
            'duration' => $this -> duration,
            'event_name' => $this->serviceAsset->service->name,
            'total_price' => $this -> total_price,
            'payment' => $this -> payment,
            'notes' => $this -> notes,
            //"photo" => json_decode($this->photo),
        ], $this->publicEvent? (new ReservationPublicResource($this->publicEvent))->toArray($request):[]);
    }
}
