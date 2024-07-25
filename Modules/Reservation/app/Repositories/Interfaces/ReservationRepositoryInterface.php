<?php

namespace Modules\Reservation\app\Repositories\Interfaces;

interface ReservationRepositoryInterface {

    public function addInfo($reservationInfo);
    
    

    public function getInfo($id);

    public function dateTime($date);

    public function listTimesToReserve($asset_id,$date, $role);

    public function listForInvestor($asset_id,$date, $service_kind);


}