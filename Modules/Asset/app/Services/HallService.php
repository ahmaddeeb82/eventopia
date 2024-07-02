<?php

namespace Modules\Asset\app\Services;



class HallService {

    public $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function add($hall) {
        return $this->repository->add($hall);
    }
   
}
