<?php

namespace Modules\Discounts\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Discounts\app\Repositories\DiscountRepository;
use Modules\Discounts\app\Services\DiscountService;
use Modules\Discounts\Http\Requests\AddDiscountRequest;

class DiscountsController extends Controller
{
    use ApiResponse;
    
    public function add(AddDiscountRequest $request) {

            (new DiscountService(new DiscountRepository()))->add($request->all());
            return $this->sendResponse(
                200,
                __('messages.add_discount')
            );
    }

    public function list() {
        return $this->sendResponse(
            200,
            __('messages.list_discounts'),
            (new DiscountService(new DiscountRepository()))->list()
            );
    }

}
