<?php

namespace Modules\Reservation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhotoPublicReservationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'photo' => 'required|mimes:png,jpg,jpeg',
            'event_id' => 'required|exists:reservations,id',
            //'photo.*' => 'required_with:photo|mimes:png,jpg,jpeg',
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
