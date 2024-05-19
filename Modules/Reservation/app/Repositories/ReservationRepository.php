<?php

namespace Modules\Reservation\app\Repositories;

use Modules\Reservation\Models\Reservation;

class ReservationRepository
{
    
    public function add($reservationInfo){

        return Reservation::create($reservationInfo);

    }


    public function update($model, $info, $identifier) {

        return $model->update([$identifier => $info]);

    } 


    public function getInfo($id){
        return Reservation::where('id',$id)->first();
    }
}