<?php

namespace Modules\Reservation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Reservation\app\Repositories\ExtraPublicEventsRepository;
use Modules\Reservation\app\Repositories\ReservationRepository;
use Modules\Reservation\app\Repositories\TicketsReservationRepository;
use Modules\Reservation\app\Services\ReservationService;
use Modules\Reservation\Http\Requests\DateReservationRequest;
use Modules\Reservation\Http\Requests\GetPrivateReservationRequest;
use Modules\Reservation\Http\Requests\GetPublicReservationRequest;
use Modules\Reservation\Http\Requests\GetReservationRequest;
use Modules\Reservation\Http\Requests\GetTimesRequest;
use Modules\Reservation\Http\Requests\PhotoPublicReservationRequest;
use Modules\Reservation\Http\Requests\ReservationRequest;
use Modules\Reservation\Http\Requests\TicketsReservationRequest;
use Modules\Reservation\Models\Reservation;
use Modules\Reservation\Transformers\ReservationResource;

class ReservationController extends Controller
{
    use ApiResponse;
    

    public function addInfoReservation(ReservationRequest $request){

        
            return (new ReservationService(new ReservationRepository))->addInfoReservationForHallOwner($request->all());
            
    }

    public function addPhoto(PhotoPublicReservationRequest $request){

        return $this -> sendResponse(
            200,
            __('messages.add_reservation'),
            (new ReservationService(new ReservationRepository())) -> addPhoto($request)
        );
    }

    public function getInfo(GetPrivateReservationRequest $request) {

        return $this -> sendResponse(
            200,
            __('messages.get_reservation'),
            (new ReservationService(new ReservationRepository))->getInfo($request -> id)
        );

    }

    public function addTickets(TicketsReservationRequest $request){
        return $this -> sendResponse(
            200,
            __('messages.add_reservation'),
            (new ReservationService(new TicketsReservationRepository))->addTickets($request->all())
        );
    }

    public function dateRes(DateReservationRequest $request){
        return $this -> sendResponse(
            200,
            __('messages.add_reservation'),
            (new ReservationService(new ReservationRepository)) -> dateTime($request)
        );
    }

    public function listTimesForHallOwner(GetTimesRequest $request){

        return $this -> sendResponse(
            200,
            __('messages.add_reservation'),
            (new ReservationService(new ReservationRepository))->getTimesForHallOwner($request->asset_id,$request->date)
            );
    }

    public function listTimesForOrganizer(GetTimesRequest $request){

        return $this -> sendResponse(
            200,
            __('messages.add_reservation'),
            (new ReservationService(new ReservationRepository))->getTimesForOrgnizer($request->asset_id,$request->date)
            );
    }

    public function addInfoReservationForOrganizer(ReservationRequest $request){

        
        return (new ReservationService(new ReservationRepository))->addInfoReservationForOrganizer($request->all());
        
}

}
