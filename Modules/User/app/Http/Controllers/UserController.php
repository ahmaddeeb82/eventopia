<?php

namespace Modules\User\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Traits\DateFormatter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Modules\User\app\Services\UserService;
use Modules\User\Http\Requests\LoginRequest;
use Modules\User\Http\Requests\RegisterRequest;
use Modules\User\app\Repositories\UserRepository;
use Modules\User\Http\Requests\AddToCartRequest;
use Modules\User\Http\Requests\AddUserRequest;
use Modules\User\Http\Requests\ForgetPasswordRequest;
use Modules\User\Http\Requests\GetInvestorsRequest;
use Modules\User\Http\Requests\GetUserWithId;
use Modules\User\Http\Requests\ResetPasswordRequest;
use Modules\User\Http\Requests\VerificationRequest;

class UserController extends Controller
{
    use ApiResponse, DateFormatter;

    /*
    Register User from the app
    */

    public function register(RegisterRequest $request){

        return $this -> sendResponse(
            200,
            __('messages.register'),
            (new UserService(new UserRepository()))->register($request -> except(['confirm_password']),'User')
        );

   }

   /*
    add organizer or hall owner from the dashboard
    */

   public function addUser(AddUserRequest $request){

    return $this -> sendResponse(
        200,
        __('messages.user_added'),
        (new UserService(new UserRepository()))->addInvestor($request -> except(['confirm_password', 'contract']), $request->role, $request->contract)
    );
   }

    public function emaiVerification(VerificationRequest $request) {
        return (new UserService(new UserRepository()))->verification($request->all());
    }


   public function login(LoginRequest $request){
    return (new UserService(new UserRepository()))->login($request->all());
    return $this->sendResponse(
        200,
        __('auth.create_user'),
        (new UserService(new UserRepository()))->login($request->all())
    );
   }

   public function logout() {

    (new UserService(new UserRepository()))->deleteToken();

    return $this->sendResponse(
        200,
        __('messages.loggedout'),
    );
   }
    public function listInvestors(GetInvestorsRequest $request) {
        
        return $this->sendResponse(
            200,
            __('messages.loggedout'),
            (new UserService(new UserRepository()))->listWithRole($request->role)
        );
    }

    public function getWithContract(GetUserWithId $request) {
        return $this->sendResponse(
            200,
            __('messages.loggedout'),
            (new UserService(new UserRepository()))->getInvestorWithContract($request->id)
        );
    }

    public function forgetPassword(ForgetPasswordRequest $request) {
        (new UserService(new UserRepository()))->forgetPassword($request->email);
        return $this->sendResponse(
            200,
            __('messages.loggedout')
        );
    }

    public function checkOtp(VerificationRequest $request) {
        return $this->sendResponse(
            200,
            __('auth.create_user'),
            (new UserService(new UserRepository()))->checkOtp($request->otp,$request->email)
        );
    }

    public function resetPassword(ResetPasswordRequest $request) {
        return $this->sendResponse(
            200,
            __('auth.create_user'),
            ((new UserService(new UserRepository()))->resetPassword($request->all()))
        );
    }

    public function addToCart(AddToCartRequest $request) {
        ((new UserService(new UserRepository()))->editToCart(auth()->user(),$request->money, '-'));

        return $this->sendResponse(
            200,
            __('auth.create_user')
           
        );
    }

}
