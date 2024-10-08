<?php

namespace Modules\User\app\Repositories\Interfaces;

use Modules\User\Http\Requests\RegisterRequest;



interface UserRepositoryInterface
{
    public function create($userInfo);
    public function get($info, $identifier);
    public function listWithRole($role);
    public function login($login_info , $login_type);
    public function update($user, $data);
}
