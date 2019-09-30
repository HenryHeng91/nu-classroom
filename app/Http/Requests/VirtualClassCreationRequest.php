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
            'classTitle' => 'string|required|max:190',
            'description' => 'string|nullable',
            'categoryId' => 'string|exists:categories,guid|required',
            'organizationId' => 'string|exists:organizations,guid|nullable',
            'startDate' => 'date_format:Y-m-d|nullable',
            'endDate' => 'date_format:Y-m-d|after:start_date|required',
            'classStartTime' => 'date_format:H:i|nullable',
            'classEndTime' => 'date_format:H:i|nullable',
            'classDays' => 'string|nullable',
            'classBackgroundsId' => 'string|exists:class_backgrounds,guid|required'
        ];
    }
}
