<?php

namespace Modules\Reservation\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'attendees_number' => 'required',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' =>  'required|date_format:Y-m-d',
            'start_time' => 'required','regex:/^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$/',
            'end_time' => 'required','regex:/^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$/',
            'payment' => 'required|boolean',
            'event_id' => 'required',
            'confirmed_guest_id' => 'required|integer|exists:users,id',
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
