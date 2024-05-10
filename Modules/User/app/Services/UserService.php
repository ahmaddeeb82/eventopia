<?php

namespace Modules\User\app\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class UserService {

    
    public $repository;

    public function __construct($repository)
    {
        $this -> repository = $repository;
    }
    

    public function create($userInfo){

        $userInfo['password'] = Hash::make('password'); 

        return $this -> repository -> create($userInfo); 

    }


    public function assignRoleUser($user, $role) {

        $user -> assignRole($role);
    }


    public function createToken($user){

        return ['token' => $user -> createToken('API TOKEN') -> plainTextToken];
    }


    public function login($user){
        $login_type = filter_var($user['login'], FILTER_VALIDATE_EMAIL )
        ? 'email'
        : 'username';

        $user->merge([
            $login_type => $user['login'],
        ]);

        if (Auth::attempt([$login_type => $user['login'], 'password' => $user['password']])) {
            return ['token' => $this->repository->login($user['login'], $login_type)->createToken('API TOKEN') -> plainTextToken];
        }
     
        
    }

}
