<?php

namespace Modules\Reservation\app\Services;

use App\Traits\DateFormatter;
use App\Traits\ImageTrait;
use App\Traits\UpdateTrait;
use Modules\Event\Models\Service;
use Modules\Event\Models\ServiceAsset;
use Modules\Reservation\app\Repositories\ExtraPublicEventsRepository;
use Modules\Reservation\Models\PublicEvent;
use Modules\Reservation\Models\Reservation;
use Modules\Reservation\Transformers\ReservationPrivateResource;
use Modules\Reservation\Transformers\ReservationPublicResource;
use Modules\Reservation\Transformers\ReservationResource;
use Modules\User\Models\User;

class ReservationService {
    use UpdateTrait;
    use DateFormatter;
    use ImageTrait;

    public $repository;

    public function __construct($repository){

        $this->repository = $repository;
    
    }


    public function addPublicEvent($reservation,$extraPublicEvents){

        $reservation -> publicEvent() 
        -> save((new ExtraPublicEventsRepository())->add($extraPublicEvents));
    
    }


    public function addInfo($reservationInfo){
        
        $reservation = $this -> repository -> addInfo($reservationInfo);
         
        $service_kind = $reservation -> services -> kind;

        $price = $reservation -> serviceAsset -> price;

        if(isset($reservation -> assets -> hall)){
        $hall = $reservation -> assets -> hall;
        $price= $price + ($hall->mixed ? $hall->mixed_price : 0) + ($hall->dinner ? $hall->dinner_price : 0);
        }

        $this -> updateWithModel ($reservation ,$price ,'total_price');

        $this -> updateWithModel (
            $reservation ,
            $this -> calcDurationForReservation($reservation -> start_time ,$reservation -> end_time) ,
            'duration');

        if($service_kind == 'public' && isset($reservationInfo['extra_public_events'])){
            $this->addPublicEvent($reservation, $reservationInfo['extra_public_events']);
        }

        return new ReservationPrivateResource($reservation);
        
    }


    public function addPhoto($public_photo){
        
        $reservation = PublicEvent::where('id',$public_photo['event_id'])->first();
        $photo = ['photo'=>$this -> savePhoto($public_photo['photo'])];
        $event = $this -> updateWithModel($reservation, $photo,'photo');
        
        return $event;

    }


    public function getInfo($id){

        $reservation = $this -> repository -> getInfo($id);

        return new ReservationPrivateResource($reservation);
        
    }


    public function addTickets($tickets){

        $reservation_tickte = $this -> repository -> addTickets($tickets);

        $reservation = PublicEvent::where('id' ,$tickets['event_id']) -> first();

        $reserved_tickets = ($reservation -> reserved_tickets + $tickets['tickets_number']);
        $this -> updateWithModel($reservation ,$reserved_tickets ,'reserved_tickets');

        $tickets_price = ($reservation -> ticket_price * $tickets['tickets_number']);
        $this -> updateWithModel($reservation_tickte,$tickets_price,'tickets_price');

        return $tickets_price;

    }


    public function getWithDate($date){

    }
    
}
