<?php

namespace Modules\Asset\app\Services;



class HallService {

    public $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function add($hall) {
        $hall['active_times'] = json_encode($hall['active_times']);
        return $this->repository->add($hall);
    }
    
}
