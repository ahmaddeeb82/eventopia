<?php

namespace Modules\Asset\app\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Asset\app\Repositories\Interfaces\AssetRepositoryInterface;
use Modules\Asset\Models\Asset;
use Modules\Event\Models\Service;

class AssetRepository implements AssetRepositoryInterface
{
    public function add($asset)
    {
        return Asset::create($asset);
    }
    
    public function getWithId($id) {
        return Asset::where('id', $id)->first();
    }

    public function update($asset, $data) {
        return $asset->update($data);
    }

    public function list($identifier, $role, $service_id = 1)
    {
        if($role == 'HallOwner') {
            $assets =  Asset::has('hall'); 
        }
        else {
            $assets =  Asset::doesntHave('hall'); 
        }
        
        switch($identifier) {
            case 'rate':
                $assets = $assets->orderByDesc('rate')->get();
                break;
            case 'price':
                $service = Service::find($service_id);
                $assets = $service->assets()->withPivot('price')->orderBy('pivot_price','desc');
                if($role == 'HallOwner') {
                    $assets =  $assets->has('hall')->get(); 
                }
                else {
                    $assets =  $assets->doesntHave('hall')->get(); 
                }
            case 'all':
                $assets = $assets->all();
                break;
            default:
                break;
        }
        return $assets;
    }

    public function recentlyAdded($role) 
    {
        if($role == 'HallOwner') {
            return Asset::has('hall')->latest()->take(7)->get(); 
        }
        else {
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
                  ->whereBetween('capacity', [$filters['audiences_number'] - 25, $filters['audiences_number'] + 25])
                  ->whereHas('times', function ($query) use ($filters) {
                      $query->where('start_time', '=', $filters['start_time'])
                             ->where('end_time', '=', $filters['end_time']);
                  });
                //   ->whereHas('serviceAssets', function ($query) use ($filters) {
                //       $query->whereBetween('price', [$filters['min_price'], $filters['max_price']]);
                //   });
        });
    } else {
        $query->whereHas('user', function ($query) use ($filters) {
            $query->where('address', 'LIKE', $filters['region'] . '%');
        });
    }

    return $query->get();

        // return DB::table('users')
        // ->select('assets.*')
        // ->distinct()
        // ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        // ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
        // ->leftJoin('assets', 'users.id', '=', 'assets.user_id')
        // ->leftJoin('halls', 'assets.id', '=', 'halls.asset_id')
        // ->leftJoin('times', 'halls.id', '=', 'times.hall_id')
        // ->join('service_asset', 'service_asset.asset_id', '=', 'assets.id')
        // ->join('services', 'services.id', '=', 'service_asset.service_id')
        // ->where('roles.name', '=', $filters['role'])
        // ->where('services.id', '=', $filters['service_id'])
        // ->when($filters['role'] == 'HallOwner', function($query) use ($filters) {
        //     return $query->where('halls.mixed' ,'=', $filters['mixed_service'])
        //     ->where('halls.dinner', '=', $filters['dinner_service'])
        //     ->where('halls.address', 'LIKE' ,$filters['region'] .'%')
        //     ->whereBetween('halls.capacity', [$filters['audiences_number']-25, $filters['audiences_number']+25])
        //     ->where('times.start_time', '=', $filters['start_time'])
        //     ->where('times.end_time', '=', $filters['end_time'])
        //     ->whereBetween('service_asset.price', [$filters['min_price'], $filters['max_price']]);
        // }, function($query) use ($filters) {
        //     return $query->where('users.address', 'LIKE',$filters['region'] .'%');
        // })
        // ->get();

    }


}