<?php

namespace App\Traits;

trait ImageTrait {
    public function savePhoto($image) {
        return $image->store('images', 'public');
    }

    public function saveMultiplePhotos($images) {
        $image_paths = [];
        $image_paths = array_map(function ($image){
            return $this->savePhoto($image);
        }, $images);
        return $image_paths;
    }
}