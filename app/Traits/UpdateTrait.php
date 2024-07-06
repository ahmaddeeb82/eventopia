<?php

namespace App\Traits;

trait UpdateTrait {
    
    public function updateWithModel($model, $info, $identifier) {

        return $model->update([$identifier => $info]);

    } 
}