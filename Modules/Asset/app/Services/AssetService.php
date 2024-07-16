<?php

namespace Modules\Asset\app\Services;

use App\Traits\ImageTrait;
use Exception;
use Illuminate\Http\Request;
use Modules\Asset\app\Repositories\AssetRepository;
use Modules\Asset\app\Repositories\HallRepository;
use Modules\Asset\Http\Requests\AssetResource;
use Modules\Asset\Models\Asset;
use Modules\Asset\Models\Time;
use Modules\Asset\Transformers\AssetRecordsResource;
use Modules\Asset\Transformers\AssetResource as TransformersAssetResource;
use Modules\Asset\Transformers\AssetResourceWithTwoNames;
use Modules\Asset\Transformers\FavoriteAssetResource;
use Modules\Asset\Transformers\HallResource;
use Modules\Event\app\Repositories\ProportionRepository;
use Modules\Event\app\Repositories\ServiceAssetRepository;
use Modules\Event\app\Repositories\ServiceRepository;
use Modules\Event\app\Services\ServiceService;
use Modules\Event\Models\Service;
use Modules\Event\Models\ServiceAsset;
use Modules\Event\Transformers\GetServiceResource;
use Modules\Event\Transformers\GetServiceWithPriceResource;
use Modules\Favorite\Models\Favorite;

class AssetService {
    use ImageTrait;

    public $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function add($asset) {
        $asset['photos']=json_encode($asset['photos']);
        $asset['user_id'] = auth()->user()->id;
        return $this->repository->add($asset);
    }

    public function attachService($asset, $service, $price = NULL, $proprtion = NULL) {
        $asset->services()->attach($service['id'], ['price'=>$price??$service['price']]);
        $added_service = (new ServiceAssetRepository())->getWithServiceAssetId($service['id'],$asset->id);
        $added_proportion = $proportion ?? $service['proportion'] ?? NULL;
        if(isset($added_proportion)) {
            $added_service->proportion()->save((new ProportionRepository())->add($added_proportion));
        }
    }
    public function attachMultipleServices($asset, $services) {
        array_map(function ($service) use ($asset) {
            $this->attachService($asset, $service);
        }, $services['existed']);

        $added_services = (new ServiceService(new ServiceRepository()))->createDisactiveServices($services['added']);
        array_map(function ($service, $index) use ($asset, $services) {
            $this->attachService(
                $asset,
                $service,
                $services['added'][$index]['price'] ?? null,
                $services['added'][$index]['proportion'] ?? null
            );
        }, $added_services, array_keys($added_services));
    }

    public function saveHall($asset, $hall) {
        $asset->hall()->save((new HallService(new HallRepository()))->add($hall));
    }

    public function saveOneTime($asset, $time) {
        $asset->times()->save(new Time($time));
    }

    public function saveTimes($asset,$times) {
        array_map(function ($time) use ($asset) {
            $this->saveOneTime($asset,$time);
        }, $times);
    }

    public function addPhotos($asset_photos) {

        return ['id' => $this->add(['photos' => $this->saveMultiplePhotos($asset_photos)])->id];
    }

    public function addCompleteAsset($asset_info) {

        $asset = $this->repository->getWithId($asset_info['id']);

        $this->attachMultipleServices($asset,$asset_info['services']);

        if(isset($asset_info['hall'])) {
            $this->saveHall($asset, $asset_info['hall']);
            $this->saveTimes($asset,$asset_info['hall']['active_times']);
        }

        if(isset($asset_info['organizer_start_time'])) {
            $this->saveOneTime($asset,
                [
                    'start_time' => $asset_info['organizer_start_time'],
                    'end_time' => $asset_info['organizer_end_time'],
                ]);
        }

    }

    public function updateWithId($data) {

        return $this->repository->update(
            $this->repository->getWithId($data['id']),
            $data);
    }

    public function update($asset, $data) {

        return $this->repository->update(
            $asset,
            $data);
    }

    public function claculateRate($data) {
        $asset = $this->repository->getWithId($data['id']);
        $data['rated_number'] = $asset->rated_number + 1;
        $data['rate'] = round((($asset->rate * $asset->rated_number) + $data['rate']) / $data['rated_number'], 1);
        return $this->update($asset, $data);
    }

    public function get($id) {
        return new AssetResourceWithTwoNames(
            $this->repository->getWithId($id)
        );
    }

    public function recentlyAdded($role) 
    {
        return AssetRecordsResource::collection($this->repository->recentlyAdded($role));
    }
    
    public function addToFavorite($id) {
        $asset = $this->repository->getWithId($id);
        $asset->usersFavorite()->attach([auth()->user()->id]);
    }

    public function getFavorites() {
        return FavoriteAssetResource::collection(auth()->user()->favoriteAssets);
    }

    public function deleteFavorite($id) {
        Favorite::where('favoritable_id', $id)->where('user_id', auth()->user()->id)->delete();
    }

    public function listForInvestor() {
        if(auth()->user()->hasRole('HallOwner')){
        return TransformersAssetResource::collection(auth()->user()->assets);
        } else {
            return GetServiceWithPriceResource::collection(auth()->user()->assets[0]->servicesWithPrice);
        }
    }

    public function updateAttachedService($service) {
        $service_to_edit = ServiceAsset::where('id', $service['id'])->first();
        $service_to_edit->update($service);
        if(isset($service['proportion'])) {
            $service_to_edit->proportion->update($service['proportion']);
        }
    }

    public function updateTime($time) {
        $time_to_edit = Time::where('id', $time['id'])->first();
        $time_to_edit->update($time);
    }

    public function updateMultipleTimes($asset, $times) {
        if(isset($times['edited'])) {
            array_map(function ($time) {
                $this->updateTime($time);
            }, $times['edited'], array_keys($times['edited']));
        }
        if(isset($times['added'])) {
            $this->saveTimes($asset,$times['added']);
        }

}

    public function updateMultipleServices($asset, $services) {
        if(isset($services['edited'])) {
            array_map(function ($service) {
                $this->updateAttachedService($service);
            }, $services['edited'], array_keys($services['edited']));
            unset($services['edited']);
        }
        if(isset($services['added']) || isset($services['existed'])) {
            $this->attachMultipleServices($asset,$services);
        }
    }

    public function updateCompleteAsset($asset_info) {
        $asset = $this->repository->getWithId($asset_info['id']);

        $this->updateMultipleServices($asset,$asset_info['services']);

        if(isset($asset_info['hall'])) {
            $asset->hall->update($asset_info['hall']);
            $this->updateMultipleTimes($asset,$asset_info['hall']['active_times']);
        }
    }

    public function filterForReservation($filters) {
        return TransformersAssetResource::collection($this->repository->filterForReservation($filters));
    }

    public function deleteAttachedService($id) {
        ServiceAsset::where('id', $id)->first()->delete();
    }

    public function deleteAsset($id){
        $asset = $this->get($id);
        $asset->delete();
    }

}
