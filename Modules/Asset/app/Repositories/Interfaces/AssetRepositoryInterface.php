<?php

namespace Modules\Asset\app\Repositories\Interfaces;

interface AssetRepositoryInterface {
    
    public function add($asset);
    public function update($asset, $data);
    public function getWithId($id);
    public function topRate();

}