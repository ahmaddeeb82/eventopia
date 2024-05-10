<?php

namespace Modules\Event\app\Repositories\Interfaces;

interface ServiceAssetRepositoryInterface {
    
    public function getWithServiceAssetId($service_id, $asset_id);

}