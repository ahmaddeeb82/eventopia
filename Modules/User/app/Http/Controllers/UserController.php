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
use Modules\User\Http\Requests\VerificationRequest;

class UserController extends Controller
{
    use ApiResponse;

    /*
    Register User from the app
    */

    public function register(RegisterRequest $request){

        return $this -> sendResponse(
            200,
            __('auth.create_user'),
            (new UserService(new UserRepository()))->create($request -> except(['confirm_password']),'User')
        );

   }

   /*
    add organizer or hall owner from the dashboard
    */

   public function addUser(RegisterRequest $request){

    return $this -> sendResponse(
        200,
        __('auth.create_user'),
        (new UserService(new UserRepository()))->create($request -> except(['confirm_password']),$request->role)
    );
   }

    public function emaiVerification(VerificationRequest $request) {
        return $this->sendResponse(
            200,
            __('auth.create_user'),
            (new UserService(new UserRepository()))->verification($request->all())
        );
    }


   public function login(LoginRequest $request){
        
    $user_object = new UserService(new UserRepository());

    $user = $user_object -> login($request);

    
   }
}
