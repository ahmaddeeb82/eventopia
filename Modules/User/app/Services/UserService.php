<?php

namespace Modules\User\app\Services;

use Ichtrojan\Otp\Otp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\User\Notifications\EmailVerificationNotification;

class UserService {

    
    public $repository;

    public function __construct($repository)
    {
        $this -> repository = $repository;
    }
    

    public function create($userInfo, $role){

        $userInfo['password'] = Hash::make('password'); 
        
        $user = $this -> repository -> create($userInfo); 

        $this->assignRoleUser($user, 'User');

        $user->notify(new EmailVerificationNotification());

        return $this->createToken($user);

    }


    public function assignRoleUser($user, $role) {

        $user -> assignRole($role);
    }


    public function createToken($user){

        return ['token' => $user -> createToken('API TOKEN') -> plainTextToken];
    }

    public function verification($data) {
        $otp = (new Otp)->validate($data['email'], $data['otp']);
        if(!$otp->status) {
            return ['verified' => false];
        }

        $this->repository->get($data['email'], 'email')->update(['email_verified_at'=> now()]);
        return ['verified' => true];
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
