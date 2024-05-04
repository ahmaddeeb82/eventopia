<?php

namespace Modules\User\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\User\app\Services\UserService;
use Modules\User\Http\Requests\RegisterRequest;
use Modules\User\app\Repositories\UserRepository;

class UserController extends Controller
{
    use ApiResponse;

    public function create(RegisterRequest $request){
        (new UserService(new UserRepository())) -> create($request -> except(['confirm_password']));
        return $this -> sendResponse(
            200,
            __('auth.create_user'),
        );

   }
}
