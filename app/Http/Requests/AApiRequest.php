<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use phpDocumentor\Reflection\Types\This;
use Waavi\Sanitizer\Laravel\SanitizesInput;

abstract class AApiRequest extends FormRequest
{
    use SanitizesInput;
    /**
     * For more sanitizer rule check https://github.com/Waavi/Sanitizer
     */
    public function validateResolved()
    {
        {
            $this->sanitize();
            parent::validateResolved();
        }
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json($validator->errors(), 422);
        throw (new ValidationException($validator, $response))->status(422);

    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public abstract function authorize();

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public abstract function rules();

}
