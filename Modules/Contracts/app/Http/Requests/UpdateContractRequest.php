<?php

namespace Modules\Contracts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContractRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:contracts,id',
            'price' => 'numeric',
            'start_date' => 'date_format:Y-m-d',
            'end_date' => 'date_format:Y-m-d',
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
