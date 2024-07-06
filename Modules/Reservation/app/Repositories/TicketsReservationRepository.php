<?php

namespace Modules\Reservation\app\Repositories;

use Modules\Reservation\Models\PublicEventReservation;

class TicketsReservationRepository{

    public function addTickets($tickets){
        //$data=$tickets->all();
        return PublicEventReservation::create($tickets);
    }
}