<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'first_name' => 'sometimes',
            'last_name' => 'sometimes',
            'username' => 'sometimes|unique:users,username,'.auth()->user()->id.',|regex:/^[A-Za-z][A-Za-z0-9_]{7,29}$/',
            'email' =>'sometimes|unique:users,email,'.auth()->user()->id.'|email',
            'address' => 'sometimes',
            'phone_number' => 'sometimes|unique:users,phone_number,'.auth()->user()->id.'|regex:/^(09)[345689][0-9]{7}$/',
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
