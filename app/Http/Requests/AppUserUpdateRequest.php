<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppUserUpdateRequest extends AApiRequest
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
            'username' => 'string|nullable',
            'firstName' => 'string|required',
            'lastName' => 'string|required',
            'gender' => 'in:male,female|required',
            'birthDate' => 'date_format:Y-m-d',
            'email' => 'email|nullable',
            'address' => 'string|nullable',
            'city' => 'string|nullable',
            'country' => 'string|nullable',
            'selfDescription' => 'string|nullable',
            'educationLevel' => 'string|nullable',
        ];
    }

    /**
     *  Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'email' => 'trim|lowercase',
            'username' => 'trim|escape',
            'selfDescription' => 'escape'
        ];
    }

}
