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
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users,username,'.auth()->user()->id.',|regex:/^[A-Za-z][A-Za-z0-9_]{7,29}$/',
            'email' =>'required|unique:users,email,'.auth()->user()->id.'|email',
            'address' => 'required',
            'phone_number' => 'required|unique:users,phone_number,'.auth()->user()->id.'|regex:/^(09)[345689][0-9]{7}$/',
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
