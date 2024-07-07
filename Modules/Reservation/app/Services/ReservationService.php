<?php

namespace Modules\Reservation\app\Services;

use App\Traits\ApiResponse;
use App\Traits\DateFormatter;
use App\Traits\ImageTrait;
use App\Traits\UpdateTrait;
use Modules\Event\Models\Service;
use Modules\Event\Models\ServiceAsset;
use Modules\Reservation\app\Repositories\ExtraPublicEventsRepository;
use Modules\Reservation\Models\PublicEvent;
use Modules\Reservation\Models\Reservation;
use Modules\Reservation\Transformers\GetTimesResource;
use Modules\Reservation\Transformers\ReservationPrivateResource;
use Modules\Reservation\Transformers\ReservationPublicResource;
use Modules\Reservation\Transformers\ReservationResource;
use Modules\Reservation\Transformers\TimeReservationResource;
use Modules\User\app\Repositories\UserRepository;
use Modules\User\app\Services\UserService;
use Modules\User\Models\User;

class ReservationService {
    use UpdateTrait, DateFormatter, ImageTrait, ApiResponse;



    public $repository;

    public function __construct($repository){

        $this->repository = $repository;
    
    }


    public function addPublicEvent($reservation,$extraPublicEvents){

        $reservation -> publicEvent() 
        -> save((new ExtraPublicEventsRepository()) -> add($extraPublicEvents));
    
    }


    public function addCategory($reservation, $category){
        
        $reservation -> publicEvent() -> category() 
        -> save((new ExtraPublicEventsRepository()) -> addCategory($category));
    }


    public function dateTime($date){
        $service_asset = ServiceAsset::where('asset_id',$date['event_id'])->first();

        $hall_id = $service_asset ->asset-> hall -> id;

        $times = $this -> repository -> dateTime($hall_id);

        return TimeReservationResource::collection($times);

    }


    public function addInfoReservationForHallOwner($reservationInfo){

        $reservationInfo['confirmed_guest_id'] = auth() -> user() -> id; 

        $reservation = $this -> repository -> addInfo($reservationInfo);
         
        $service_kind = $reservation -> service -> kind;

        $price = $reservation -> serviceAsset -> price;

        if(isset($reservation -> assets -> hall)){
        $hall = $reservation -> assets -> hall;
        $price= $price + ($reservation->mixed ? $hall->mixed_price : 0) + ($reservation->dinner ? $hall->dinner_price : 0);
        }

        
        if($reservationInfo['payment_type'] == 'electro') {
            if($price > auth()->user()->money) {
                $reservation->delete();
                return $this -> sendResponse(
                    200,
                    __('messages.add_reservation'),
                    new ReservationPrivateResource($reservation)
                );
            }
            (new UserService(new UserRepository()))->editToCart(auth()->user(), $price, '-');
            (new UserService(new UserRepository()))->editToCart($reservation->assets->user, $price, '+');
            $reservation->update([
                'payment' => true,
            ]);
        } else {
            $reservation->update([
                'payment' => false,
            ]);
        }
        
        $this -> updateWithModel ($reservation ,$price ,'total_price');

        $this -> updateWithModel (
            $reservation ,
            $this -> calcDurationForReservation($reservation -> time ->start_time ,$reservation  -> time -> end_time) ,
            'duration');

        if($service_kind == 'public' && isset($reservationInfo['extra_public_events'])){
            $this -> addPublicEvent($reservation, $reservationInfo['extra_public_events']);
            $this -> addCategory($reservation, $reservationInfo['extra_public_events.category']);
        }
        return $this -> sendResponse(
            200,
            __('messages.add_reservation'),
            new ReservationPrivateResource($reservation)
            );
        
    }

    public function addInfoReservationForOrganizer($reservationInfo){

        $reservationInfo['confirmed_guest_id'] = auth() -> user() -> id; 

        $reservation = $this -> repository -> addInfo($reservationInfo);
         
        $service_kind = $reservation -> service -> kind;

        $price = $reservation -> serviceAsset -> price;

        if(isset($reservation -> assets -> hall)){
        $hall = $reservation -> assets -> hall;
        $price= $price + ($reservation->mixed ? $hall->mixed_price : 0) + ($reservation->dinner ? $hall->dinner_price : 0);
        }

        $this -> updateWithModel ($reservation ,$price ,'total_price');

        $this -> updateWithModel (
            $reservation ,
            $this -> calcDurationForReservation($reservation -> time ->start_time ,$reservation  -> time -> end_time) ,
            'duration');

        if($service_kind == 'public' && isset($reservationInfo['extra_public_events'])){
            $this -> addPublicEvent($reservation, $reservationInfo['extra_public_events']);
            $this -> addCategory($reservation, $reservationInfo['extra_public_events.category']);
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

    public function getTimesForHallOwner($asset_id, $date) {
        return GetTimesResource::collection($this->repository->listTimesToReserveForHallOwner($asset_id, $date));
    }

    public function checkReservationTimeForOrganizer() {

    }


    public function getWithDate($date){

    }
    
}
