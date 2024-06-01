<?php

namespace Modules\Reservation\app\Repositories;

use Modules\Reservation\Models\PublicEvent;
use Modules\Reservation\Models\PublicEventReservation;
use Modules\Reservation\Models\Reservation;

class ReservationRepository
{
    
    public function addInfo($reservationInfo){

        return Reservation::create($reservationInfo);

    }


    public function update($model, $info, $identifier) {

        return $model->update([$identifier => $info]);

    } 


    public function getInfo($id){

        return Reservation::where('id',$id)->first();
    
    }

}