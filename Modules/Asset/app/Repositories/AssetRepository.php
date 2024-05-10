<?php

namespace Modules\Asset\app\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Asset\app\Repositories\Interfaces\AssetRepositoryInterface;
use Modules\Asset\Models\Asset;

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

    public function topRate()
    {
        return Asset::orderByDesc('rate')->get();
    }

}