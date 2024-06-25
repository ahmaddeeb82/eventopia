<?php

namespace Modules\User\Http\Requests;

use App\Exceptions\MyValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     */

    protected function failedValidation(Validator $validator) {
        throw new MyValidationException($validator);
    }
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
            'address' => 'required|string',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'phone_number' => 'required|unique:users,phone_number|regex:/^(09)[345689][0-9]{7}$/',
            'role' => 'sometimes|string|in:Organizer,HallOwner',
            'contract' => 'array|required',
            'contract.price' => 'required_with:contract|numeric',
            'contract.start_date' => 'required_with:contract|date_format:Y-m-d',
            'contract.end_date' => 'required_with:contract|date_format:Y-m-d',
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
