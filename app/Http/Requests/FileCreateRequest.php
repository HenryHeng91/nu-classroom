<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileCreateRequest extends AApiRequest
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
            'name' => 'string|nullable|max:250',
            'description' => 'string|nullable|max:500',
            'fileType' => 'exists:file_types,name|nullable',
            'source' => 'required_if:fileType,LINK|nullable',
            'access' => 'exists:accesses,name|nullable',
            'file' => 'file|required_unless:fileType,LINK|max:'.(env('FILE_UPLOADSIZE_MB') * 1024),
            'useIn' => 'in:POST,COMMENT,MATERIAL,PROFILE,COVER|nullable',
        ];

    }
}
