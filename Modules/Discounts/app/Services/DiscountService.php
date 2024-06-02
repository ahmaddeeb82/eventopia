<?php

namespace Modules\Discounts\app\Services;

use App\Traits\DateFormatter;
use Modules\Discounts\Transformers\GetDiscountResource;

class DiscountService {
    use DateFormatter;

    public $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function add($info) {
        $info['duration'] = $this->calcDuration($info['start_date'], $info['end_date']);
        $info['disconted_price'] = 0;
        $discount = $this->repository->add($info);
        $info['disconted_price'] = $discount->serviceAsset->price * (100 -$info['percentage'])/ 100;
        $discount->update([
            'disconted_price' => $info['disconted_price'],
        ]);
    }

    public function list() {
        return GetDiscountResource::collection($this->repository->list());
    }

}
