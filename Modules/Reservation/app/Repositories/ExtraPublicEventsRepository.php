<?php

namespace Modules\Reservation\app\Repositories;

use Modules\Reservation\Models\Category;
use Modules\Reservation\Models\PublicEvent;
use Modules\Reservation\Models\PublicEventReservation;
use Modules\Reservation\Models\Reservation;

class ExtraPublicEventsRepository{
    
    public function add($extraPublicEvents){

        return new PublicEvent($extraPublicEvents);
    
    }

    public function addCategory($categry){

        return new Category($categry);

    }

}