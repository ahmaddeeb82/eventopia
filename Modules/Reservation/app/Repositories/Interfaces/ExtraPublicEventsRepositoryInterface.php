<?php

namespace Modules\Reservation\app\Repositories\Interfaces;

interface ExtraPublicEventsRepositoryInterface{
    public function add($extraPublicEvents);

    public function addCategory($category);

    public function getCategory($id);
    
    //public function tickets($tickets);
}