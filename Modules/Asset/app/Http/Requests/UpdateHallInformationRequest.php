<?php

namespace Modules\Asset\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Event\Enums\ServiceKindEnum;

class UpdateHallInformationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:assets,id',
            'services' => 'sometimes',
            'services.existed' => 'sometimes|array',
            'services.existed.*.id' => 'required_with:services.existed.*|integer|exists:services,id',
            'services.existed.*.price' => 'required_with:services.existed.*|numeric',
            'services.existed.*.proportion' => 'sometimes|integer',
            'services.added' => 'sometimes|array',
            'services.added.*.kind' => ['required_with:services.added.*', Rule::enum(ServiceKindEnum::class)],
            'services.added.*.name' => 'required_with:services.added.*|array:ar,en',
            'services.added.*.name.ar' => 'required_with:services.added.*.name|string',
            'services.added.*.name.en' => 'required_with:services.added.*.name|string',
            'services.edited.*.id' => 'required_with:services.edited.*|integer|exists:service_asset,id',
            'services.edited.*.price' => 'required_with:services.edited.*|numeric',
            'services.edited.*.proportion' => 'sometimes|integer',
            'hall' => 'sometimes',
            'hall.name' => 'required_with:hall|array:ar,en',
            'hall.name.ar' => 'required_with:hall.name|string',
            'hall.name.en' => 'required_with:hall.name|string',
            'hall.capacity' => 'required_with:hall|numeric',
            'hall.address' => 'required_with:hall|string',
            'hall.dinner' => 'required_with:hall|boolean',
            'hall.mixed' => 'required_with:hall|boolean',
            'hall.dinner_price' => 'required_with:hall|numeric',
            'hall.mixed_price' => 'required_with:hall|numeric',
            'hall.active_times' => 'required_with:hall|array',
            'hall.active_time.added.*' => 'array|required_with:hall.active_times',
            'hall.active_time.added.*.start_time' => 'required_with:hall.active_times.added.*|date_format:H:i:s',
            'hall.active_time.added.*.end_time' => 'required_with:hall.active_times.added.*|date_format:H:i:s',
            'hall.active_time.edited.*' => 'array|required_with:hall.active_times',
            'hall.active_time.edited.*.id' => 'required_with:hall.active_times.added.*|integer|exists:times,id',
            'hall.active_time.edited.*.start_time' => 'required_with:hall.active_times.added.*|date_format:H:i:s',
            'hall.active_time.edited.*.end_time' => 'required_with:hall.active_times.added.*|date_format:H:i:s',

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
