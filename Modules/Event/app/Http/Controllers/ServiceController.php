<?php

namespace Modules\Event\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Modules\Event\App\Repositories\ServiceRepository;
use Modules\Event\app\Services\ServiceService;
use Modules\Event\Http\Requests\GetServiceRequest;
use Modules\Event\Http\Requests\ListServicesRequest;
use Modules\Event\Http\Requests\ServiceRequest;
use Modules\Event\Http\Requests\UpdateServiceRequest;
use Modules\Event\Models\Service;

class ServiceController extends Controller
{
    use ApiResponse;

    public function create(ServiceRequest $request) {
        (new ServiceService(new ServiceRepository()))->createMultipleServices($request->services);
        return $this->sendResponse(200,__('messages.create_service'));
    }

    public function update(UpdateServiceRequest $request) {
        (new ServiceService(new ServiceRepository()))->editService($request->all());

        return $this->sendResponse(200,__('messages.update_service'));

    }

    public function get(GetServiceRequest $request) {
        (new ServiceService(new ServiceRepository()))->getService($request->id);

        return $this->sendResponse(
            200,
            __('messages.retrieve_service'),
            (new ServiceService(new ServiceRepository()))->getService($request->id),
        );

    }

    public function delete(GetServiceRequest $request) {
        (new ServiceService(new ServiceRepository()))->deleteService($request->id);

        return $this->sendResponse(
            200,
            __('messages.delete_service'),
        );

    }

    public function list(ListServicesRequest $request) {
        
        return $this->sendResponse(
            200,
            __('messages.list_services'),
            (new ServiceService(new ServiceRepository()))->list($request->identifier),
        );

    }

}
