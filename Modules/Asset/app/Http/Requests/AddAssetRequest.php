<?php

namespace Modules\Asset\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddAssetRequest extends FormRequest
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
            'services.existed.*.id' => 'required_with:services|exists:services,id|integer',
            'services.existed.*.price' => 'required_with:services|numeric',
            'services.existed.*.proportion' => 'sometimes|integer',
            'services.added' => 'sometimes|array',
            'services.added.*.kind' => 'required_with:services|in:public,private',
            'services.added.*.name' => 'required_with:services|array:ar,en',
            'services.added.*.name.ar' => 'required_with:name|string',
            'services.added.*.name.en' => 'required_with:name|string',
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
            'hall.active_time.*' => 'array|required_with:hall.active_times',
            'hall.active_time.*.opening' => 'required_with:hall.active_times.*|date_format:H:i:s',
            'hall.active_time.*.closing' => 'required_with:hall.active_times.*|date_format:H:i:s',


            
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
