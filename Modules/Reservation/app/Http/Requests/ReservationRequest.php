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
            'event_id' => 'required|exists:service_asset,id',
            'confirmed_guest_id' => 'required|exists:users,id',
            'extra_public_events' => 'sometimes',
            'extra_public_events.category' => 'required_with:extra_public_events|array:ar,en',
            'extra_public_events.category.ar' => 'required_with:extra_public_events.category|string',
            'extra_public_events.category.en' => 'required_with:extra_public_events.category|string',
            'extra_public_events.description' => 'required_with:extra_public_events',
            'extra_public_events.name' => 'required_with:extra_public_events',
            'extra_public_events.address' => 'required_with:extra_public_events',
            'extra_public_events.ticket_price' => 'required_with:extra_public_events',
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
