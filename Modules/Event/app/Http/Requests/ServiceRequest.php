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
            'kind' => 'required|in:public,private',
            'name' => 'required|array:ar,en',
            'name.ar' => 'required|string',
            'name.en' => 'required|string',
        ];
    }

    
}
