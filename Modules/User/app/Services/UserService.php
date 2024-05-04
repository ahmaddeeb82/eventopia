<?php

namespace Modules\User\app\Services;

use Illuminate\Support\Facades\Hash;



class UserService {

    
    public $repository;

    public function __construct($repository)
    {
        $this -> repository = $repository;
    }
    

    public function create($userInfo){
        
        $userInfo['password'] = Hash::make(['password']); 

        $this -> repository -> create($userInfo); 

    }
}
