<?php

namespace App\Http\Requests;


class JoinClassRequest extends AApiRequest
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
            'classId' => 'string|required',
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
}
