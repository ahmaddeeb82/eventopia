<?php

namespace Modules\Event\app\Services;

use Modules\Event\Transformers\GetServiceResource;

class ServiceService {

    public $repository;

    public function __construct($repository) {
        $this->repository = $repository;
    }

    public function createService($attributes) {

        $this->repository->create($attributes);

    }

    public function editService($attributes) {
        $this->repository->edit(
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

}
