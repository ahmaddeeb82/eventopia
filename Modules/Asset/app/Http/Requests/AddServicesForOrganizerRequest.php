<?php

namespace Modules\Asset\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Event\Enums\ServiceKindEnum;

class AddServicesForOrganizerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'services' => 'required',
            'services.existed' => 'sometimes|array',
            'services.existed.*.id' => 'required_with:services|integer|exists:services,id',
            'services.existed.*.price' => 'required_with:services|numeric',
            'services.existed.*.proportion' => 'sometimes|integer',
            'services.added' => 'sometimes|array',
            'services.added.*.kind' => ['required_with:services', Rule::enum(ServiceKindEnum::class)],
            'services.added.*.name' => 'required_with:services|array:ar,en|required_array_keys:ar,en',
            'services.added.*.name.ar' => 'required_with:name|string',
            'services.added.*.name.en' => 'required_with:name|string',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
