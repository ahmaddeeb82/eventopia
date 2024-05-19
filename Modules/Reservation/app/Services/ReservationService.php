<?php

namespace Modules\Reservation\app\Services;

use Illuminate\Support\Carbon;
use Modules\Asset\Models\Asset;
use Modules\Event\Models\ServiceAsset;
use Modules\Reservation\Models\Reservation;
use Modules\Reservation\Transformers\ReservationResource;
use Modules\User\Models\User;

class ReservationService {
    public $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }


    public function add($reservationInfo){

        $confirmed_guest_id = $reservationInfo['confirmed_guest_id'];
        User::where('confirmed_guest_id',$confirmed_guest_id);

        $event_id = $reservationInfo['event_id'];
        ServiceAsset::where('event_id',$event_id);

        $reservation = $this -> repository -> add($reservationInfo);

        $price = $reservation->serviceAsset->price;
        $hall = $reservation->assets->hall;
        $price= $price + ($hall->mixed?$hall->mixed_price:0) + ($hall->dinner?$hall->dinner_price:0);

        $this -> repository -> update ($reservation ,$price, 'total_price');

        return $reservation;
        
    }


    public function getInfo($id){

        $reservation = $this -> repository -> getInfo($id);

        return new ReservationResource($reservation);
        
    }

    
}
