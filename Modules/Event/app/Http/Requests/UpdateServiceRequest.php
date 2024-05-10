<?php

namespace Modules\Event\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|exists:services,id',
            'kind' => 'required|in:public,private',
            'name' => 'required|array:ar,en',
            'name.ar' => 'required|string',
            'name.en' => 'required|string',
            'proportion' => 'sometimes|integer',
        ];
    }
}
