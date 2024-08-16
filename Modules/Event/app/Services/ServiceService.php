<?php

namespace Modules\Event\app\Services;

use Modules\Event\Transformers\GetServiceResource;
use Modules\Notification\Services\NotificationService;

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
            $added_services[] = $this->createService($service);
        }

        NotificationService::send('e51E6B8I8n09JYRUfUG8mA:APA91bFa8BU_HTG0V9jW8M0xNWJCzX3m_HEdvCtxsaQ2ACBPxUOPyQETTaHJQC4HW9F_UU9T4kzIB7b8WL6Onpk7rnTt7KDkmxeoqnDLXDiKc6WU1JBYXzfLcr_7Qq1U9a9hoCDeiRUL', __('messages.add_service_notification_name'),__('messages.add_service_notification_content', ['service' => $added_services[0]->name]));

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
