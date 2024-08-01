<?php

namespace Modules\Reservation\app\Repositories;

use Carbon\Carbon;
use DateTime;
use Modules\Asset\Models\Asset;
use Modules\Asset\Models\Time;
use Modules\Reservation\app\Repositories\Interfaces\ReservationRepositoryInterface;
use Modules\Reservation\Models\PublicEvent;
use Modules\Reservation\Models\PublicEventReservation;
use Modules\Reservation\Models\Reservation;

class ReservationRepository implements ReservationRepositoryInterface
{

    public function addInfo($reservationInfo)
    {

        return Reservation::create($reservationInfo);
    }


    public function getInfo($id)
    {
        return Reservation::where('id', $id)->first();
    }

    public function dateTime($date)
    {
        return Time::where('hall_id', $date)->get();
    }

    public function listTimesToReserve($asset_id, $date, $role)
    {

        $asset = Asset::where('id', $asset_id)->first();

        $allTimes = Time::where('asset_id', $asset_id)->get();

        $reservations = $asset->reservations()->where('start_date', $date)->get();

        $reservedTimes = $reservations->pluck('time_id')->toArray();


        $availableTimes = $allTimes->filter(function ($time) use ($reservedTimes, $role, $asset) {
            return $role == 'HallOwner' ? !in_array($time->id, $reservedTimes) : in_array($time->id, $reservedTimes) && $time != $asset->times()->first();
        });

        return $availableTimes->values();
    }

    public function listForInvestor($asset_id, $date, $service_kind)
    {
        $asset = Asset::where('id', $asset_id)->first();

        if ($asset) {
            $reservations = $asset->serviceAssets()
                ->whereHas('service', function ($query) use ($service_kind) {
                    $query->where('kind', $service_kind);
                })
                ->with(['reservations' => function ($query) use ($date) {
                    $query->where('start_date', $date, Carbon::today());
                }])
                ->get()
                ->pluck('reservations')
                ->flatten();

            return $reservations;
        }
        return [];
    }

    public function listForUser($date, $service_kind)
    {
        return Reservation::where('confirmed_guest_id', auth()->user()->id)
            ->where('start_date', $date, Carbon::today())
            ->whereHas('serviceAsset', function ($query) use ($service_kind) {
                return $query->whereHas('service', function ($query) use ($service_kind) {
                    return $query->where('kind', $service_kind);
                });
            })
            ->get();
    }

    public function listPublicEvents($category_id)
    {
        if($category_id == 0) {
            return Reservation::where('start_date', '>', Carbon::today())->get();
        }
        else {
            return Reservation::whereHas('publicEvent.category', function ($query) use ($category_id) {
                return $query->where('id', $category_id);
            })
            ->where('start_date', '>', Carbon::today())
            ->get();
        }
    }
}
