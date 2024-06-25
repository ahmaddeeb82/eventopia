<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\MyValidationException;

class ResetPasswordRequest extends FormRequest
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
        return array_merge([
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ],Auth::check()?['old_password' => 'required|min:6']: []);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
