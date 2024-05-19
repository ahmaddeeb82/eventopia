<?php

namespace Modules\Contracts\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Contracts\app\Repositories\ContractRepository;
use Modules\Contracts\app\Services\ContractService;
use Modules\Contracts\Http\Requests\AddContractRequest;
use Modules\Contracts\Http\Requests\GetContractWithId;
use Modules\Contracts\Http\Requests\GetUserContractsRequest;

class ContractsController extends Controller
{
    use ApiResponse;
    public function add(AddContractRequest $request) {
        (new ContractService(new ContractRepository()))->create($request->all());

        return $this->sendResponse(
            200,
            __('messages.loggedout'),
        );
    }

    public function list(GetUserContractsRequest $request) {
        return $this->sendResponse(
            200,
            __('messages.loggedout'),
            (new ContractService(new ContractRepository()))->list($request->user_id)
        );
    }

    public function get(GetContractWithId $request) {

        return $this->sendResponse(
            200,
            __('messages.loggedout'),
            (new ContractService(new ContractRepository()))->getWithId($request->id)
        );
    }
}
