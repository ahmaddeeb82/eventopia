<?php

namespace Modules\Reservation\app\Repositories\Interfaces;

interface ExtraPublicEventsRepositoryInterface{
    public function add($extraPublicEvents);

    public function addCategory($categry);
    
    //public function tickets($tickets);
}