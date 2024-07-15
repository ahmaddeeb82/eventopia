<?php

namespace Modules\Reservation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Event\Models\ServiceAsset;

class PublicEventReservationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'general_info' => 'required|array|required_array_keys:start_date,end_date,event_id, attendees_number, mixed, dinner, payment_type',
            'general_info.start_date' => 'required|date_format:Y-m-d',
            'general_info.end_date' =>  'required|date_format:Y-m-d',
            'general_info.notes' => 'sometimes',
            'general_info.start_time' => 'sometimes','regex:/^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$/',
            'general_info.end_time' => 'sometimes','regex:/^(2[0-3]|[01]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$/',
            'general_info.time_id' => 'sometimes|integer|exists:times,id',
            'general_info.event_id' => 'required|integer|exists:service_asset,id',
            'general_info.attendees_number' => 'required|integer|max:' . ServiceAsset::where('id', $this->event_id)->first()->asset->capacity,
            'general_info.mixed' => 'required|boolean',
            'general_info.dinner' => 'required|boolean',
            'general_info.payment_type' => 'required|in:electro,cash',
            'public_info' => 'required|array|required_array_keys:category,description,name, address, ticket_price, photo',
            'public_info.category' => 'required|array',
            'public_info.category.existed' => 'sometimes|integer|exists:categories,id',
            'public_info.category.added' => 'sometimes|array|required_array_keys:ar,en',
            'public_info.description' => 'required|max:100',
            'public_info.name' => 'required|string',
            'public_info.address' => 'required|string',
            'public_info.ticket_price' => 'required|numeric',
            'photo' => 'required|mimes:png,jpg,jpeg',
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
