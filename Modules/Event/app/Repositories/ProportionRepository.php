<?php

namespace Modules\Event\app\Repositories;

use Modules\Event\app\Repositories\Interfaces\ProportionRepositoryInterface;
use Modules\Event\Models\PublicEventProportion;

class ProportionRepository implements ProportionRepositoryInterface
{

    public function add($proportion) {
        return new PublicEventProportion(['proportion'=> $proportion]);
    }

    
    
}