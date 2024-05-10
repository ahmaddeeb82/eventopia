<?php

namespace Modules\Asset\app\Repositories\Interfaces;

interface AssetRepositoryInterface {
    
    public function add($asset);
    public function getWithId($id);

}