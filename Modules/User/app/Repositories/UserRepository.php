<?php

namespace Modules\User\app\Repositories;

use Modules\User\Models\User;
use Modules\User\app\Repositories\Interfaces\UserRepositoryInterface;



class UserRepository implements UserRepositoryInterface
{
    
    public function create($userInfo)
    {
        return User::create($userInfo); 
    }

    public function login($login_info , $login_type){

        return User::where($login_type,$login_info)->first();
    }

    
}