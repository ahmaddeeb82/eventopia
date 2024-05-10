<?php

namespace Modules\Event\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'services' => 'required|array',
            'services.*.kind' => 'required|in:public,private',
            'services.*.name' => 'required|array:ar,en',
            'services.*.name.ar' => 'required|string',
            'services.*.name.en' => 'required|string',
            'services.*.proportion' => 'sometimes|integer',
        ];
    }

    
}
