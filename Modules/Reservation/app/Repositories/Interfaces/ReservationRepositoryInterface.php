<?php

namespace Modules\Reservation\app\Repositories\Interfaces;

interface ReservationRepositoryInterface {

    public function addInfo($reservationInfo);
    
    //public function update($model, $info, $identifier);

    public function getInfo($id);

    public function dateTime($date);

}