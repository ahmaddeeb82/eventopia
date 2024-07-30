<?php

namespace Modules\User\app\Services;

use App\Traits\ApiResponse;
use App\Traits\DateFormatter;
use App\Traits\ImageTrait;
use Modules\User\Transformers\ProfileResource;

class ProfileService {

    use DateFormatter, ApiResponse, ImageTrait;

    
    public $repository;

    public function __construct($repository)
    {
        $this -> repository = $repository;
    }

    public function get() {
        return new ProfileResource(auth()->user());
    }

    public function update($data) {
        return new ProfileResource($this->repository->update(auth()->user(),$data));
    }

    public function setPhoto($photo) {
        return new ProfileResource($this->repository->update(auth()->user(),['photo' => $this->savePhoto($photo)]));
    }

    public function deletePhoto() {
        return new ProfileResource($this->repository->update(auth()->user(),['photo' => null]));
    }
}