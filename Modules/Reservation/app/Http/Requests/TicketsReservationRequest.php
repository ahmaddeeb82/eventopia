<?php

namespace Modules\Reservation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketsReservationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'tickets_number' => 'required',
            'event_id' => 'required|exists:reservations,id',
            'user_id' => 'required|exists:users,id',
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
