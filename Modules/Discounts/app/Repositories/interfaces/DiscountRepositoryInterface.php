<?php

namespace Modules\Discounts\app\Repositories\Interfaces;


interface DiscountRepositoryInterface
{
    public function add($info);
    public function list();
}
