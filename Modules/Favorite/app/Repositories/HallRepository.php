<?php

namespace Modules\Asset\app\Repositories;

use Modules\Asset\app\Repositories\Interfaces\HallRepositoryInterface;
use Modules\Asset\Models\Hall;

class HallRepository implements HallRepositoryInterface
{
    public function add($hall)
    {
        return new Hall($hall);
    }
    
    
}