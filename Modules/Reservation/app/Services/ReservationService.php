<?php

namespace Modules\Reservation\app\Services;

use App\Traits\ApiResponse;
use App\Traits\DateFormatter;
use App\Traits\ImageTrait;
use App\Traits\UpdateTrait;
use DateTime;
use Illuminate\Support\Facades\DB;
use Modules\Asset\app\Repositories\AssetRepository;
use Modules\Asset\app\Services\AssetService;
use Modules\Event\Models\ServiceAsset;
use Modules\Reservation\app\Repositories\ExtraPublicEventsRepository;
use Modules\Reservation\Models\Category;
use Modules\Reservation\Models\PublicEvent;
use Modules\Reservation\Models\PublicEventReservation;
use Modules\Reservation\Models\Reservation;
use Modules\Reservation\Transformers\CategoryResource;
use Modules\Reservation\Transformers\GetTimesResource;
use Modules\Reservation\Transformers\PublicEventTicketsResource;
use Modules\Reservation\Transformers\ReservationPrivateResource;
use Modules\User\app\Repositories\UserRepository;
use Modules\User\app\Services\UserService;

class ReservationService
{
    use UpdateTrait, DateFormatter, ImageTrait, ApiResponse;



    public $repository;

    public function __construct($repository)
    {

        $this->repository = $repository;
    }




    public function addCategory($category)
    {
        return (new ExtraPublicEventsRepository)->addCategory($category);
    }


    public function processPayment($reservation, $payment_type, $price, $user_to_add, $user_to_take)
    {
        if ($payment_type == 'electro') {
            if ($price > auth()->user()->money) {
                throw new \Exception(__('messages.no_enough_money')); // Use custom messages or handle accordingly
            }
            $this->updateUserCart($reservation, $user_to_add, $user_to_take, $price);
        } else {
            $reservation->update(['payment' => false]);
        }
    }

    public function updateUserCart($reservation, $user_to_add, $user_to_take, $price)
    {
        (new UserService(new UserRepository()))->editToCart($user_to_take, $price, '-');
        (new UserService(new UserRepository()))->editToCart($user_to_add, $price, '+');
        $reservation->update(['payment' => true]);
    }

    public function checkReservationAvailability($start_time, $end_time, $event_id, $date) {
        $asset = ServiceAsset::where('id', $event_id)->first()->asset;
        $times = $this->getTimesForOrgnizer($asset['id'], $date);

        $startTime1 = new DateTime($start_time);
        $endTime1 = new DateTime($end_time);
        $startTime3 = new DateTime($asset->times()->first()->start_time);
        $endTime3 = new DateTime($asset->times()->first()->end_time);

        $times->each(function ($time) use ($startTime1, $endTime1, $startTime3, $endTime3) {
            $startTime2 = new DateTime($time->start_time);
            $endTime2 = new DateTime($time->end_time);
            if ((($startTime1 < $endTime2) && ($startTime2 < $endTime1)) || // Check for intersection
                !(($startTime3 <= $startTime1) && ($endTime1 <= $endTime3)) // Ensure it's not surrounded by startTime3 and endTime3
            ) {
                throw new \Exception(__('messages.time_fail'));
            }
        });

        (new AssetService(new AssetRepository()))->saveOneTime($asset, ['start_time' => $start_time, 'end_time' => $end_time]);
        return $asset->times()->orderBy('created_at', 'desc')->first()->id;
    }

    public function addInfoReservation($reservationInfo, $returned_data = true)
    {

        $reservationInfo['confirmed_guest_id'] = auth()->user()->id;

        DB::beginTransaction();

        try {
            if (!isset($reservationInfo['time_id'])) {
                $reservationInfo['time_id'] = $this->checkReservationAvailability(
                    $reservationInfo['start_time'],
                    $reservationInfo['end_time'],
                    $reservationInfo['event_id'],
                    $reservationInfo['start_date']
                );
            }
            $reservation = $this->repository->addInfo($reservationInfo);



            $price = $reservation->serviceAsset->price;

            if (isset($reservation->serviceAsset->asset->hall)) {
                $hall = $reservation->serviceAsset->asset->hall;
                $price = $price + ($reservation->mixed ? $hall->mixed_price : 0) + ($reservation->dinner ? $hall->dinner_price : 0);
            }

            $this->processPayment($reservation, $reservationInfo['payment_type'], $price, $reservation->serviceAsset->asset->user, auth()->user());

            $this->updateWithModel($reservation, $price, 'total_price');

            $this->updateWithModel(
                $reservation,
                $this->calcDurationForReservation($reservation->time->start_time, $reservation->time->end_time),
                'duration'
            );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if($returned_data) {
            return $this->sendResponse(
                200,
                $e->getMessage(),
            );
        } else {
            throw new \Exception($e->getMessage());
        }
        }

        return $returned_data?new ReservationPrivateResource($reservation):$reservation;
    }

    

    public function getTimesForHallOwner($asset_id, $date)
    {
        return GetTimesResource::collection($this->repository->listTimesToReserve($asset_id, $date, 'HallOwner'));
    }

    public function getTimesForOrgnizer($asset_id, $date)
    {
        return GetTimesResource::collection($this->repository->listTimesToReserve($asset_id, $date, 'Organizer'));
    }

    public function savePublicEvent($reservation, $public_info) {
        $reservation->publicEvent()->save((new ExtraPublicEventsRepository)->add($public_info));
    }
    
    public function addPhotoForPublicEvent($reservation_id, $photo) {
        $reservation = $this->repository->getInfo($reservation_id);
        $reservation->publicEvent->update(['photo' => $this->savePhoto($photo)]);
        return $this->sendResponse(
            200,
            __('messages.add_reservation'),
            new ReservationPrivateResource($reservation)
        );
    }

    public function eventReservation($reservation_info) {
        try{
            DB::beginTransaction();
            if(ServiceAsset::where('id', $reservation_info['general_info']['event_id'])->first()->service->kind == 'private') {
                $response_data = $this->addInfoReservation($reservation_info['general_info']);
            } else {
            $reservation = $this->addInfoReservation($reservation_info['general_info'], false);
            if(!empty($reservation_info['public_info']['category']['added'])) {
                $reservation_info['public_info']['info']['category_id'] = $this->addCategory($reservation_info['public_info']['category']['added'])->id;
            } else if (isset($reservation_info['public_info']['category']['existed'])) {
                $reservation_info['public_info']['info']['category_id'] = (new ExtraPublicEventsRepository)->getCategory($reservation_info['public_info']['category']['existed']['id'])->id;
            }
            $this->savePublicEvent($reservation,$reservation_info['public_info']['info']);
            $response_data = $reservation->id;
        }

        DB::commit();
    } catch(\Exception $e) {
        DB::rollBack();
        return $this->sendResponse(
            200,
            $e->getMessage(),
        );
    }
        return $this->sendResponse(
            200,
            __('messages.add_reservation'),
            $response_data
        );

    }

    public function listCategories() {
        return CategoryResource::collection(Category::all());
    }

    public function listForInvestor($asset_id,$date, $service_kind) {
        if(auth()->user()->hasRole('Organizer')) {
            return auth()->user()->assets()->first()?ReservationPrivateResource::collection($this->repository->listForInvestor(auth()->user()->assets()->first()->id,$date, $service_kind)):[];
        }
        return ReservationPrivateResource::collection($this->repository->listForInvestor($asset_id,$date, $service_kind));
    }

    public function listForUser($date, $service_kind) {
        return ReservationPrivateResource::collection($this->repository->listForUser($date, $service_kind));
    }

    public function listPublicEvents($category_id) {
        return ReservationPrivateResource::collection($this->repository->listPublicEvents($category_id));
    }

    public function get($id) {
        return new ReservationPrivateResource($this->repository->getInfo($id));
    }

    public function reserveTicket($data) {
        $reservation = $this->repository->getInfo($data['event_id']);

        $data['event_id'] = $reservation->publicEvent->id;

        $data['user_id'] = auth()->user()->id;
        $data['tickets_price'] = $reservation->publicEvent->ticket_price * $data['tickets_number'];

        $hostage_income = $data['tickets_price'] * (100 - $reservation->serviceAsset->proportion->proportion) / 100;
        $investor_income = $data['tickets_price'] * $reservation->serviceAsset->proportion->proportion / 100;

        DB::beginTransaction();

        try {
        $public_event = PublicEventReservation::create($data);

        $this->checkTicketsNumber($reservation, $data['tickets_number']);

        $this->processPayment($public_event,$data['payment_type'], $hostage_income, $reservation->user, auth()->user());

        $this->processPayment($public_event,$data['payment_type'], $investor_income, $reservation->serviceAsset->asset->user, auth()->user());

        DB::commit();

        return $this->sendResponse(
            200,
            __('messages.add_reservation'),
            new PublicEventTicketsResource($public_event)
        );

        return new PublicEventTicketsResource($public_event);

        } catch(\Exception $e) {

            DB::rollBack();

            return $this->sendResponse(
                200,
                $e->getMessage(),
            );
        }
    }

    public function checkTicketsNumber($reservation, $tickets_number) {
        if ($tickets_number + $reservation->publicEvent->reserved_tickets > $reservation->attendees_number) {
                throw new \Exception(__('messages.no_enough_places')); // Use custom messages or handle accordingly
        } else {
            $reservation->publicEvent->reserved_tickets += $tickets_number;
            $reservation->publicEvent->save();
        }
    }

    public function listTickets() {
        return PublicEventTicketsResource::collection(PublicEventReservation::where('user_id', auth()->user()->id)->get());
    }
}