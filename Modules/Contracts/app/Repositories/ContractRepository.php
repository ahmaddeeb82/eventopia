<?php

namespace Modules\Contracts\app\Repositories;

use Modules\Contracts\app\Repositories\Interfaces\ContractRepositoryInterface;
use Modules\Contracts\Models\Contract;

class ContractRepository implements ContractRepositoryInterface
{
    
    public function add($info)
    {
        return new Contract($info);
    }

    public function create($info)
    {
        return Contract::create($info);
    }

    public function listWithTrashed($user_id){
        return Contract::where('user_id', $user_id)->withTrashed()->orderByDesc('created_at')->get();
    }

    public function get($info, $identifier)
    {
        return Contract::withTrashed()->where($identifier, $info)->first();
    }
}