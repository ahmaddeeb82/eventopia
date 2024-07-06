<?php

namespace Modules\Event\app\Services;

use Modules\Event\Transformers\GetServiceResource;

class ServiceService {

    public $repository;

    public function __construct($repository) {
        $this->repository = $repository;
    }

    public function createService($service) {
        return $this->repository->create($service);
    }

    public function createMultipleServices($services) {

        foreach($services as $service) {
            $this->createService($service);
        }

    }

    public function createDisactiveServices($services) {
        $added_services = [];
        foreach($services as $service) {
            $service = $this->createService($service);
            $service->delete();
            $added_services[] = $service;
        }
        return $added_services;
    }

    public function editService($attributes) {
        return $this->repository->edit(
            $attributes,
            $this->repository->getWithId($attributes['id'])
        );
    }

    public function getService($id) {
        return new GetServiceResource($this->repository->getWithId($id));
    }

    public function deleteService($id) {
        $this->repository->delete($this->repository->getWithId($id));
    }

    public function list($identifier) {
        return GetServiceResource::collection($this->repository->list($identifier));
    }


}
