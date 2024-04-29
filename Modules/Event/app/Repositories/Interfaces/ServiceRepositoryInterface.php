<?php

namespace Modules\Event\app\Repositories\Interfaces;

interface ServiceRepositoryInterface {
    
    public function create($attributes);
    public function getWithId($id);
    public function edit($attributes, $service);
    

}