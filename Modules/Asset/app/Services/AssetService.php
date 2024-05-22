<?php

namespace Modules\Asset\app\Services;

use App\Traits\ImageTrait;
use Exception;
use Illuminate\Http\Request;
use Modules\Asset\app\Repositories\AssetRepository;
use Modules\Asset\app\Repositories\HallRepository;
use Modules\Asset\Http\Requests\AssetResource;
use Modules\Asset\Transformers\AssetRecordsResource;
use Modules\Asset\Transformers\AssetResource as TransformersAssetResource;
use Modules\Asset\Transformers\HallResource;
use Modules\Event\app\Repositories\ProportionRepository;
use Modules\Event\app\Repositories\ServiceAssetRepository;
use Modules\Event\app\Repositories\ServiceRepository;
use Modules\Event\app\Services\ServiceService;
use Modules\Event\Transformers\GetServiceResource;

class AssetService {
    use ImageTrait;

    public $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function add($asset) {
        $asset['photos']=json_encode($asset['photos']);
        $asset['user_id'] = 20;
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

    public function addPhotos($asset_photos) {

        return ['id' => $this->add(['photos' => $this->saveMultiplePhotos($asset_photos)])->id];
    }

    public function addCompleteAsset($asset_info) {

        $asset = $this->repository->getWithId($asset_info['id']);

        $this->attachMultipleServices($asset,$asset_info['services']);

        if(isset($asset_info['hall'])) {
        $this->saveHall($asset, $asset_info['hall']);
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
        return new TransformersAssetResource(
            $this->repository->getWithId($id)
        );
    }

    public function recentlyAdded($role) 
    {
        return AssetRecordsResource::collection($this->repository->recentlyAdded($role));
    } 
}
