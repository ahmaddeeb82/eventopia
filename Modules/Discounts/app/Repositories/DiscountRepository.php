<?php

namespace Modules\Discounts\app\Repositories;

use Modules\Discounts\app\Repositories\Interfaces\DiscountRepositoryInterface;
use Modules\Discounts\Models\Discount;

class DiscountRepository implements DiscountRepositoryInterface
{
    
    public function add($info)
    {
        return Discount::create($info);
    }

    public function list()
    {
        return Discount::all();
    }
    
}