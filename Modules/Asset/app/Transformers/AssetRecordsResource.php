<?php

namespace Modules\Asset\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetRecordsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->hall != null ?$this->hall->name:$this->user->first_name . ' ' . $this->user->last_name,
            'photo' => $this->hall != null ? json_decode($this->photos)[0]:$this->user->photo,
        ];
    }
}
