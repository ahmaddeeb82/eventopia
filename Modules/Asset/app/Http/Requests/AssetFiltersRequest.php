<?php

namespace Modules\Asset\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetFiltersRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'service_id' => 'required|integer|exists:services,id',
            'mixed_service' => 'required|boolean',
            'dinner_service' => 'required|boolean',
            'region' => 'required|string',
            'audiences_number' => 'required|integer',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s',
            'min_price' => 'required|numeric',
            'max_price' => 'required|numeric|gt:min_price',
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
