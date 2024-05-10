<?php

namespace Modules\User\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Modules\User\app\Services\UserService;
use Modules\User\Http\Requests\LoginRequest;
use Modules\User\Http\Requests\RegisterRequest;
use Modules\User\app\Repositories\UserRepository;

class UserController extends Controller
{
    use ApiResponse;

    /*
    Register User from the app
    */

    public function register(RegisterRequest $request){

        $user_object = new UserService(new UserRepository());

        $user = $user_object -> create($request -> except(['confirm_password']));

        $user_object->assignRoleUser($user, 'User');

        return $this -> sendResponse(
            200,
            __('auth.create_user'),
            $user_object->createToken($user)
        );

   }

   /*
    add organizer or hall owner from the dashboard
    */

   public function addUser(RegisterRequest $request){

        $user_object = new UserService(new UserRepository());

        $user = $user_object -> create($request -> except(['confirm_password','role']));

        $user_object->assignRoleUser($user , $request -> role);

        return $this -> sendResponse(
            200,
            __('auth.create_user'),
            $user_object->createToken($user)
        );
   }


   public function login(LoginRequest $request){
        
    $user_object = new UserService(new UserRepository());

    $user = $user_object -> login($request);

    
   }
}
