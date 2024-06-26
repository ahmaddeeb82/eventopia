<?php

namespace Modules\User\app\Services;

use App\Traits\DateFormatter;
use Ichtrojan\Otp\Otp;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\Contracts\app\Repositories\ContractRepository;
use Modules\User\Notifications\EmailVerificationNotification;
use Modules\User\Notifications\ResetPasswordNotification;
use Modules\User\Transformers\GetInvestorsResource;
use Modules\User\Transformers\GetInvestorWithContractResource;
use Modules\User\Transformers\InvestorResource;

class UserService {

    use DateFormatter;

    
    public $repository;

    public function __construct($repository)
    {
        $this -> repository = $repository;
    }

    public function create($userInfo, $role) {

        $userInfo['password'] = Hash::make($userInfo['password']); 
        
        $user = $this -> repository -> create($userInfo); 

        $this->assignRoleUser($user, $role);

        return $user;

    }
    

    public function register($userInfo, $role){

        $user = $this->create($userInfo, $role);

        $user->notify(new EmailVerificationNotification());

        return $this->createToken($user);

    }

    public function addInvestor($userInfo, $role, $contract) {
        $user = $this->create($userInfo, $role);
        $contract['duration'] = $this->calcDuration($contract['start_date'], $contract['end_date']);
        $user->contracts()->save((new ContractRepository)->add($contract));
        return new InvestorResource($user);
    }


    public function assignRoleUser($user, $role) {

        $user -> assignRole($role);
    }


    public function createToken($user){

        return [
            'token' => $user -> createToken('API TOKEN') -> plainTextToken,
            'role' => $user->getRoleNames()[0]
        ];
    }

    public function checkOtp($otp, $email) {
        $otp = (new Otp)->validate($email, $otp);
        if(!$otp->status) {
            return false;
        }
        return true;
    }

    public function verification($data) {
        if(!$this->checkOtp($data['otp'],auth()->user()->email)) {
            return ['verified' => false];
        }

        $this->repository->get($data['email'], 'email')->update(['email_verified_at'=> now()]);
        return ['verified' => true];
    }

    public function forgetPassword($email) {
        $user = $this->repository->get($email, 'email');
        $user->notify(new ResetPasswordNotification());
    }


    public function resetPassword($data) {
        if(isset($data['old_password']) && !auth()->attempt(['email' => auth()->user()->email, 'password' => $data['old_password']])) {
            throw new ValidationException(new Validator());
        }
        $user = $this->repository->get($data['email'], 'email');
        $user->update(['password'=> Hash::make($data['password'])]);
        return $this->createToken($user);
    }


    public function login($user){
        $login_type = filter_var($user['login'], FILTER_VALIDATE_EMAIL )
        ? 'email'
        : 'username';


        if (auth()->attempt([$login_type => $user['login'], 'password' => $user['password']])) {
            
            return $this->createToken($this->repository->login($user['login'], $login_type));
        } else {
            return [];
        }
    }

    public function deleteToken() {
        $user = auth()->user();

        $user->currentAccessToken()->delete();
        
    }

    public function listWithRole($role) {
        $users = $this->repository->listWithRole($role);
        return GetInvestorsResource::collection($users);
    }

    public function getInvestorWithContract($id) {
        $user = $this->repository->get($id, 'id');

        return new GetInvestorWithContractResource($user);
    }

}
