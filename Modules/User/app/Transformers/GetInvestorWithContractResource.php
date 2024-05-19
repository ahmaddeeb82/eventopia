<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Contracts\Transformers\ContractResource;

class GetInvestorWithContractResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'name'=> $this->first_name . ' ' . $this->last_name,
            'contract' => new ContractResource($this->contracts->last()),
        ];
    }
}
