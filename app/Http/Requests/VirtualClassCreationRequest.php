<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VirtualClassCreationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'class_title' => 'string|required|max:190',
            'description' => 'string|nullable',
            'category_id' => 'string|required',
            'organization_id' => 'string|nullable',
            'start_date' => 'date_format:Y-m-d|nullable',
            'end_date' => 'date_format:Y-m-d|after:start_date|required',
            'class_start_time' => 'date_format:HH:MM|nullable',
            'class_end_time' => 'date_format:HH:MM|nullable',
            'class_days' => 'string|nullable',
            'classBackgrounds_id' => 'numberic|required'
        ];
    }
}
