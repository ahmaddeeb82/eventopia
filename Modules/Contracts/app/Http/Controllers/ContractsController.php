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
use Modules\Contracts\Http\Requests\UpdateContractRequest;

class ContractsController extends Controller
{
    use ApiResponse;
    public function add(AddContractRequest $request) {
        (new ContractService(new ContractRepository()))->create($request->all());

        return $this->sendResponse(
            200,
            __('messages.add_contract'),
        );
    }

    public function list(GetUserContractsRequest $request) {
        return $this->sendResponse(
            200,
            __('messages.list_contract'),
            (new ContractService(new ContractRepository()))->list($request->user_id)
        );
    }

    public function get(GetContractWithId $request) {

        return $this->sendResponse(
            200,
            __('messages.get_contract'),
            (new ContractService(new ContractRepository()))->getWithId($request->id)
        );
    }
    
    public function getPdf(GetContractWithId $request) {
        return (new ContractService(new ContractRepository()))->getContractPdf($request->id);
    }

    public function disactive(GetContractWithId $request) {

        return $this->sendResponse(
            200,
            __('messages.disactive_contract'),
            (new ContractService(new ContractRepository()))->disactive($request->id)
        );
    }

    public function update(UpdateContractRequest $request) {

        return $this->sendResponse(
            200,
            __('messages.update_contract'),
            (new ContractService(new ContractRepository()))->update($request->all())
        );
    }
}
