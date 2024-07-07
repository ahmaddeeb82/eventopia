<?php

namespace Modules\Reservation\app\Repositories;

use Modules\Asset\Models\Asset;
use Modules\Asset\Models\Time;
use Modules\Reservation\app\Repositories\Interfaces\ReservationRepositoryInterface;
use Modules\Reservation\Models\PublicEvent;
use Modules\Reservation\Models\PublicEventReservation;
use Modules\Reservation\Models\Reservation;

class ReservationRepository implements ReservationRepositoryInterface{
    
    public function addInfo($reservationInfo){

        return Reservation::create($reservationInfo);

    }


    public function getInfo($id){

        return Reservation::where('id',$id) -> first();
    
    }

    public function dateTime($date){
//->orderBy('start_time', 'asc')
        return Time::where('hall_id',$date) -> get();

    }

    public function listTimesToReserveForHallOwner($asset_id, $date)
    {
        
        $asset = Asset::where('id', $asset_id)->first();

        $allTimes = Time::where('asset_id', $asset_id)->get();

        $reservations = $asset->reservations()->where('start_date', $date)->get();

        $reservedTimes = $reservations->pluck('time_id')->toArray();

        $availableTimes = $allTimes->filter(function ($time) use ($reservedTimes) {
            return !in_array($time->id, $reservedTimes);
        });

        return $availableTimes->values();
    }


}