<?php

namespace Modules\Reservation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Reservation\app\Repositories\ReservationRepository;
use Modules\Reservation\app\Services\ReservationService;
use Modules\Reservation\Http\Requests\GetReservationRequest;
use Modules\Reservation\Http\Requests\ReservationRequest;
use Modules\Reservation\Models\Reservation;
use Modules\Reservation\Transformers\ReservationResource;

class ReservationController extends Controller
{
    use ApiResponse;
    

    public function add(ReservationRequest $request){
        $reservation = (new ReservationService(new ReservationRepository))->add($request->all());
        return $this -> sendResponse(
            200,
            __('messages.add_reservation'),
            new ReservationResource($reservation)
        );
    }

    public function getInfo(GetReservationRequest $request) {
        return $this -> sendResponse(
            200,
            __('messages.get_reservation'),
            (new ReservationService(new ReservationRepository))->getInfo($request -> id)
        );

        // $reservation = Reservation::find(1);

        // return $reservation->assets->hall;
    }
}
