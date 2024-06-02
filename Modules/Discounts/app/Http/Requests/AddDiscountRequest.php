<?php

namespace Modules\Discounts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddDiscountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'percentage' => 'required|numeric|min:1|max:100',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
            'event_id' => 'required|integer|exists:service_asset,id'
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
