<?php

namespace Modules\Event\app\Repositories;

use Modules\Event\app\Repositories\Interfaces\ServiceRepositoryInterface;
use Modules\Event\Models\Service;

class ServiceRepository implements ServiceRepositoryInterface
{

    
    public function create($attributes) {

        return Service::create($attributes);

    }

    public function getWithId($id) {
        
        return Service::where('id', $id)->firstOrFail();

    }

    public function edit($attributes, $service) {

        $service->update($attributes);

    }
    
}