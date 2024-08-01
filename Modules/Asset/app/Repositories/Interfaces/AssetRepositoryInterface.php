<?php

namespace Modules\Asset\app\Repositories\Interfaces;

interface AssetRepositoryInterface {
    
    public function add($asset);
    public function update($asset, $data);
    public function getWithId($id);
    public function list($identifier, $role, $id = 1);
    public function recentlyAdded($role);
    public function filterForReservation($filters);
    public function getInvestorsCount($role);
    public function searchLike($identifier, $value);
    public function searchBetween($identifier, $value);
}