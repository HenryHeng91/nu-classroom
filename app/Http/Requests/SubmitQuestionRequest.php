<?php

namespace App\Http\Requests;

use App\Models\AppUser;
use App\Models\Question;

class SubmitQuestionRequest extends AApiRequest
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
            'questionId' => 'exists:questions,guid|required',
            'questionType' => 'exists:question_types,name|required',
            'answer.answerDetail' => 'required_if:questionType,WRITE|string',
            'answer.userAnswerIndex' => 'required_unless:questionType,WRITE|integer'
        ];
    }
}
