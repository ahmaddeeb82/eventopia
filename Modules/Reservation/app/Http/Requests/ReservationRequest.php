<?php

namespace Modules\Reservation\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Event\Models\ServiceAsset;

class ReservationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' =>  'required|date_format:Y-m-d',
            'notes' => 'sometimes',
            'start_time' => 'sometimes','regex:/^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$/',
            'end_time' => 'sometimes','regex:/^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$/',
            'time_id' => 'sometimes|integer|exists:times,id',
            'event_id' => 'required|integer|exists:service_asset,id',
            'attendees_number' => 'required|integer|max:' . ServiceAsset::where('id', $this->event_id)->first()->asset->capacity,
            'mixed' => 'required|boolean',
            'dinner' => 'required|boolean',
            'payment_type' => 'required|in:electro,cash',
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
