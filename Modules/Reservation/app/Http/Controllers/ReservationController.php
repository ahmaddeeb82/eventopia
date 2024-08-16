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
use Modules\Reservation\Http\Requests\AddPhotoForPublicEventRequest;
use Modules\Reservation\Http\Requests\DateReservationRequest;
use Modules\Reservation\Http\Requests\GetPrivateReservationRequest;
use Modules\Reservation\Http\Requests\GetPublicReservationRequest;
use Modules\Reservation\Http\Requests\GetReservationRequest;
use Modules\Reservation\Http\Requests\GetTicketRequest;
use Modules\Reservation\Http\Requests\GetTimesRequest;
use Modules\Reservation\Http\Requests\ListForInvestorRequest;
use Modules\Reservation\Http\Requests\ListForUserRequest;
use Modules\Reservation\Http\Requests\ListPublicEventRequest;
use Modules\Reservation\Http\Requests\PhotoPublicReservationRequest;
use Modules\Reservation\Http\Requests\PublicEventReservationRequest;
use Modules\Reservation\Http\Requests\PublicEventTicketsRequest;
use Modules\Reservation\Http\Requests\ReservationRequest;
use Modules\Reservation\Http\Requests\TicketsReservationRequest;
use Modules\Reservation\Models\Reservation;
use Modules\Reservation\Transformers\ReservationResource;

class ReservationController extends Controller
{
    use ApiResponse;


    public function listTimesForHallOwner(GetTimesRequest $request)
    {

        return $this->sendResponse(
            200,
            __('messages.add_reservation'),
            (new ReservationService(new ReservationRepository))->getTimesForHallOwner($request->asset_id, $request->date)
        );
    }

    public function listTimesForOrganizer(GetTimesRequest $request)
    {

        return $this->sendResponse(
            200,
            __('messages.add_reservation'),
            (new ReservationService(new ReservationRepository))->getTimesForOrgnizer($request->asset_id, $request->date)
        );
    }

    

    public function reserveEvent(PublicEventReservationRequest $request) {
        return (new ReservationService(new ReservationRepository))->eventReservation($request->all());
    }

    public function addPhotoForPublicEvent(AddPhotoForPublicEventRequest $request) {
        return (new ReservationService(new ReservationRepository))->addPhotoForPublicEvent($request->id, $request->photo);
    }

    public function listCategories() {
        return $this->sendResponse(
            200,
            __('messages.add_reservation'),
        (new ReservationService(new ReservationRepository))->listCategories());
    }

    public function listForInvestor(ListForInvestorRequest $request) {
        return $this->sendResponse(
            200,
            __('messages.add_reservation'),
            (new ReservationService(new ReservationRepository))->listForInvestor($request->asset_id,$request->date, $request->service_kind));
    }

    public function listForUser(ListForUserRequest $request) {
        return $this->sendResponse(
            200,
            __('messages.add_reservation'),
        (new ReservationService(new ReservationRepository))->listForUser($request->date, $request->service_kind));
    }

    public function listPublicEvents(ListPublicEventRequest $request) {
        return $this->sendResponse(
            200,
            __('messages.add_reservation'),
        (new ReservationService(new ReservationRepository))->listPublicEvents($request->category_id));
    }

    public function get(GetReservationRequest $request) {
        return $this->sendResponse(
            200,
            __('messages.add_reservation'),
        (new ReservationService(new ReservationRepository))->get($request->id));
    }

    public function reserveTicket(PublicEventTicketsRequest $request) {
        return (new ReservationService(new ReservationRepository))->reserveTicket($request->all());
    }

    public function listTickets() {
        return $this->sendResponse(
            200,
            __('messages.add_reservation'),
        (new ReservationService(new ReservationRepository))->listTickets());
    }

    public function updatePayment(GetReservationRequest $request) {
        (new ReservationService(new ReservationRepository))->updatePayement($request->id);

        return $this->sendResponse(
            200,
            __('messages.add_reservation'),
        );
    }

    public function updateTicketPayment(GetTicketRequest $request) {
        return (new ReservationService(new ReservationRepository))->updateTicketPayment($request->id);
    }

    public function addPublicEventToFavorite(GetReservationRequest $request) {
        (new ReservationService(new ReservationRepository))->addPublicEventToFavorite($request->id);
        return $this->sendResponse(200,
        __('messages.rate'),
        );
    }

    public function getPublicEventFavorites() {
        
        return $this->sendResponse(200,
        __('messages.rate'),
        (new ReservationService(new ReservationRepository))->getPublicEventFavorites()
        );
    }

    public function deletePublicEventFavorite(GetReservationRequest $request) {
        (new ReservationService(new ReservationRepository))->deletePublicEventFavorite($request->id);
        return $this->sendResponse(200,
        __('messages.rate'),
        );
    }

    public function listTicketsForPublicEvent(GetReservationRequest $request) {
        return $this->sendResponse(200,
        __('messages.rate'),
        (new ReservationService(new ReservationRepository))->listTicketsForPublicEvent($request->id)
        );
    }

    public function getCategoriesForAdmin() {
        return $this->sendResponse(200,
        __('messages.rate'),
        (new ReservationService(new ReservationRepository))->getCategoriesForAdmin()
        );
    } 

    public function AcceptCategory(Request $request) {
        (new ReservationService(new ReservationRepository))->AcceptCategory($request->all());
        return $this->sendResponse(200,
        __('messages.rate'),
        );
    }
    }

