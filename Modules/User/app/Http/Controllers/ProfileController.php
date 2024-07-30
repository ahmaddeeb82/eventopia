<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\app\Repositories\UserRepository;
use Modules\User\app\Services\ProfileService;
use Modules\User\Http\Requests\ProfileUpdateRequest;
use Modules\User\Http\Requests\SetPhotoRequest;
use Modules\User\Models\User;

class ProfileController extends Controller
{
    use ApiResponse;
    
    public function get() {
        return $this->sendResponse(
            200,
            __('messages.add_reservation'),
            (new ProfileService(new UserRepository()))->get(),
        );
    }

    public function update(ProfileUpdateRequest $request) {
        return $this->sendResponse(
            200,
            __('messages.add_reservation'),
            (new ProfileService(new UserRepository()))->update($request->all()),
        );
    }

    public function setPhoto(SetPhotoRequest $request) {
        return $this->sendResponse(
            200,
            __('messages.add_reservation'),
            (new ProfileService(new UserRepository()))->setPhoto($request->photo),
        );
    }

    public function deletePhoto() {
        return $this->sendResponse(
            200,
            __('messages.add_reservation'),
            (new ProfileService(new UserRepository()))->deletePhoto(),
        );
    }

    public function viewContract() {
        $user = User::where('id',2)->first();
        return view('contracts.contract')->with(['user' => $user]);
    }

    public function viewReport() {
        $users = User::whereHas('roles',function ($query) {
            return $query->where('name', 'Organizer')
            ->orWhere('name', 'HallOwner');
        })->get();
        return view('reports.reports')->with(['users' => $users]);
    }
}
