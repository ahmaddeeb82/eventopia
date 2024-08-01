<?php

namespace Modules\Event\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Event\Enums\ServiceKindEnum;

class UpdateServiceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|exists:services,id',
            'kind' => ['required', Rule::enum(ServiceKindEnum::class)],
            'name' => 'required|array:ar,en',
            'name.ar' => 'required|string',
            'name.en' => 'required|string',
            'proportion' => 'sometimes|integer',
        ];
    }
}
