<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users|regex:/^[A-Za-z][A-Za-z0-9_]{7,29}$/',
            'email' =>'required|unique:users|email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'address' => 'required',
            'phone_number' => 'required|unique:users,phone_number|regex:/^(09)[345689][0-9]{7}$/',
            'role' => 'sometimes|string|in:Organizer,HallOwner',
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
