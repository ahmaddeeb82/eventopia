<?php

namespace Modules\Contracts\app\Services;

use App\Traits\DateFormatter;
use Modules\Contracts\Models\Contract;
use Modules\Contracts\Transformers\ContractResource;
use Modules\Contracts\Transformers\GetContractsWithUserResource;

class ContractService {
   use DateFormatter;

   public $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

   public function create($info) {
    Contract::where('user_id', $info['user_id'])->latest()->delete();
    $info['duration'] = $this->calcDuration($info['start_date'],$info['end_date']);
    return $this->repository->create($info);
   }

   public function list($user_id) {
      return ContractResource::collection($this->repository->listWithTrashed($user_id));
   }

   public function getWithId($id) {
      return new GetContractsWithUserResource($this->repository->get($id,'id'));
   }
}
