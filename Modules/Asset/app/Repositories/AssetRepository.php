<?php

namespace Modules\Asset\app\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Asset\app\Repositories\Interfaces\AssetRepositoryInterface;
use Modules\Asset\Models\Asset;
use Modules\Event\Models\Service;
use Modules\Event\Models\ServiceAsset;
use Modules\Reservation\Models\PublicEventReservation;
use Modules\Reservation\Models\Reservation;
use Modules\User\Models\User;

class AssetRepository implements AssetRepositoryInterface
{
    public function add($asset)
    {
        return Asset::create($asset);
    }

    public function getWithId($id)
    {
        return Asset::where('id', $id)->first();
    }

    public function update($asset, $data)
    {
        return $asset->update($data);
    }

    public function list($identifier, $role, $service_id = 1)
    {
        if ($role == 'HallOwner') {
            $assets =  Asset::has('hall');
        } else {
            $assets =  Asset::doesntHave('hall');
        }

        switch ($identifier) {
            case 'rate':
                $assets = $assets->orderByDesc('rate')->get();
                break;
            case 'price':
                $service = Service::find($service_id);
                if ($role == 'HallOwner') {
                    $assets = $service->assets()->has('hall')->withPivot('price')->orderBy('pivot_price', 'desc')->get();
                    //$assets =  $assets->has('hall')->get();
                } else {
                    $assets = $service->assets()->doesntHave('hall')->withPivot('price')->orderBy('pivot_price', 'desc')->get();
                    //$assets =  $assets->doesntHave('hall')->get();
                }
                break;
            case 'all':
                $assets = $assets->get();
                break;
            default:
                break;
        }
        return $assets;
    }

    public function recentlyAdded($role)
    {
        if ($role == 'HallOwner') {
            return Asset::has('hall')->latest()->take(7)->get();
        } else {
            return Asset::doesntHave('hall')->latest()->take(7)->get();
        }
    }

    public function filterForReservation($filters)
    {
        $query = Asset::query()
            ->select('assets.*')
            ->distinct()
            ->whereHas('user', function ($query) use ($filters) {
                $query->whereHas('roles', function ($query) use ($filters) {
                    $query->where('name', $filters['role']);
                });
            })
            ->whereHas('serviceAssets', function ($query) use ($filters) {
                $query->whereHas('service', function ($query) use ($filters) {
                    $query->where('id', $filters['service_id'])
                        ->whereBetween('price', [$filters['min_price'], $filters['max_price']]);
                });
            });

        if ($filters['role'] == 'HallOwner') {
            $query->whereHas('hall', function ($query) use ($filters) {
                $query->where('mixed', '=', $filters['mixed_service'])
                    ->where('dinner', '=', $filters['dinner_service'])
                    ->where('address', 'LIKE', $filters['region'] . '%')
                    ->whereBetween('capacity', [$filters['audiences_number'] - 25, $filters['audiences_number'] + 25]);
            })
                ->whereHas('times', function ($query) use ($filters) {
                    $query->where('start_time', '=', $filters['start_time'])
                        ->where('end_time', '=', $filters['end_time']);
                });
        } else {
            $query->whereHas('user', function ($query) use ($filters) {
                $query->where('address', 'LIKE', $filters['region'] . '%');
            });
        }

        return $query->get();


    }

    public function getInvestorsCount($role) {
        return User::whereHas('roles', function ($query) use ($role) {
            $query->where('name', $role);
        })->count();
    }

    public function getMostReserved() {
        $most_reserved = Asset::withCount(['serviceAssets as reservations_count' => function($query) {
            $query->join('reservations', 'service_asset.id', '=', 'reservations.event_id');
        }])
            ->orderBy('reservations_count', 'desc')
            ->first();
        return $most_reserved?->hall?$most_reserved->hall->name:$most_reserved?->user->first_name . ' ' . $most_reserved?->user->last_name;
    }

    public function getTotalSales() {
        $reservations = Reservation::sum('total_price');
        $tickets = PublicEventReservation::sum('tickets_price');
        return $reservations + $tickets;
    }

    public function searchLike($identifier, $value) {
         return Asset::whereHas('user', function ($query) use ($value) {
            return $query->where('first_name', 'LIKE', '%'.$value.'%')
            ->orWhere('last_name', 'LIKE', '%'.$value.'%')
            ->orWhere('address', 'LIKE', '%'.$value.'%');
         })
         ->orWhereHas('hall', function ($query) use ($identifier,$value) {
            return $query->where($identifier,'LIKE', '%'.$value.'%');
         })->get();
    }

    public function searchBetween($identifier, $value) {
            return Asset::whereHas('hall', function ($query) use ($identifier,$value) {
                return $query->whereBetween($identifier, [$value - 25, $value + 25]);
             })->get();
    }

    public function searchforAssetOrganizer($value) {
        return auth()->user()->assets()->first()->serviceAssets()->whereHas('service', function ($query) use ($value) {
            return $query->where('name', 'LIKE', '%'.$value.'%');
        })->get();
    }

    public function searchForAssetHallOwner($value) {
        return auth()->user()->assets()->whereHas('hall', function ($query) use ($value) {
            return $query->where('name', 'LIKE', '%'.$value.'%');
        })
        ->get();
    }

    public function searchForReservations($value) {
        $reservations = auth()->user()->assets->map(function ($asset) use ($value){
            return $asset->serviceAssets()
            ->with(['reservations' => function ($query) use ($value) {
                $query->where('start_date','>', $value);
            }])
            ->get()
            ->pluck('reservations')
            ->flatten();
        });
        return $reservations;
    }
}
