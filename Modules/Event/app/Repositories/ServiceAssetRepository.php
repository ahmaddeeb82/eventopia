<?php

namespace Modules\Event\app\Repositories;

use Modules\Event\app\Repositories\Interfaces\ProportionRepositoryInterface;
use Modules\Event\app\Repositories\Interfaces\ServiceAssetRepositoryInterface;
use Modules\Event\Models\PublicEventProportion;
use Modules\Event\Models\ServiceAsset;

class ServiceAssetRepository implements ServiceAssetRepositoryInterface
{

    public function getWithServiceAssetId($service_id, $asset_id) {
        return ServiceAsset::where('asset_id',$asset_id)->where('service_id', $service_id)->first();
    }
    
}