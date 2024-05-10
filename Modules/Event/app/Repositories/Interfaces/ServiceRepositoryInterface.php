<?php

namespace Modules\Event\app\Repositories\Interfaces;

interface ServiceRepositoryInterface {
    
    public function create($attributes);
    public function edit($attributes, $service);
    public function getWithId($id);
    public function delete($service);
    public function list();
    

}