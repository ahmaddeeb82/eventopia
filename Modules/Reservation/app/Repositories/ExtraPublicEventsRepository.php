<?php

namespace Modules\Reservation\app\Repositories;

use Modules\Reservation\app\Repositories\Interfaces\ExtraPublicEventsRepositoryInterface;
use Modules\Reservation\Models\Category;
use Modules\Reservation\Models\PublicEvent;
use Modules\Reservation\Models\PublicEventReservation;
use Modules\Reservation\Models\Reservation;

class ExtraPublicEventsRepository implements ExtraPublicEventsRepositoryInterface{
    
    public function add($extraPublicEvents){

        return new PublicEvent($extraPublicEvents);
    
    }

    public function addCategory($category){

        return Category::create($category);

    }

    public function getCategory($id)
    {
        return Category::find($id);
    }

}