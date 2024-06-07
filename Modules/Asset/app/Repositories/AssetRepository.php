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
        //return Asset::orderByDesc('rate')->get();
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

}