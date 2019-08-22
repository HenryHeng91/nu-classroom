<?php

namespace App\Http\Requests;


class PostCreateRequest extends AApiRequest
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
            'detail' => 'string|required',
            'classId' => 'exists:virtual_classes,guid|nullable',
            'access' => 'in:PUBLIC,TEAM,PRIVATE|required',
            'postType' => 'in:POST,ASSIGNMENT,EXAM,QUESTION|required',
            'classwork' => 'required_if:postType,>,0',
            'questions' => 'required_if:postType,=,EXAM|array',
            'fileId' => 'exists:files,guid|nullable'
        ];

    }
}
