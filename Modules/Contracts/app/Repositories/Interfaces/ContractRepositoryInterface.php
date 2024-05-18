<?php

namespace Modules\Contracts\app\Repositories\Interfaces;

interface ContractRepositoryInterface {
    
    public function add($info);
    public function create($info);
    public function listWithTrashed($user_id);
    public function get($info , $identifier);
}