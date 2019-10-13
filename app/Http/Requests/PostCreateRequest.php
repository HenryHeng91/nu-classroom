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
            'classwork' => 'required_unless:postType,POST',
            'fileId' => 'exists:files,guid|nullable',

            /* Validation for post that contain a classwork
             *
             * */
            'classwork.title' => 'required_with:classwork|string',
            'classwork.description' => 'required_with:classwork|string',

            // For classwork with type == Exam or Assignment
            'classwork.startDate' => 'required_if:postType,=,ASSIGNMENT,EXAM|date_format:Y-m-d H:i',
            'classwork.endDate' => 'required_if:postType,=,ASSIGNMENT,EXAM|date_format:Y-m-d H:i',

            // For classwork with type == Exam
            'classwork.examDuration' => 'required_if:classwork.questionType,=,EXAM|integer',
            'classwork.showResultAt' => 'required_if:classwork.isAutoGrade,=,1|in:IMMEDIATE,EXAM_FINISH',
            'classwork.isAutoGrade' => 'required_if:classwork.questionType,=,EXAM|boolean',
            'classwork.classworkNotify' => 'required_if:classwork.questionType,=,EXAM|date_format:Y-m-d H:i|nullable',

            // For Classwork with type question:
            'classwork.questions' => 'required_if:postType,=,EXAM|array',
            'classwork.questions.*.questionType' => 'exists:question_types,name|required_with:classwork.questions',
            'classwork.questions.*.answer' => 'required_unless:classwork.questions.*.questionType,WRITE',
            'classwork.questions.*.answer.correctAnswerIndex' => 'integer|nullable',
            'classwork.questions.*.answer.items' => 'required_if:classwork.questions.*.questionType,MULTI_CHOICE|array',
            'classwork.questions.*.answer.items.*.answerDetail' => 'required_with:classwork.questions.*.answer.*.items|string',

            'classwork.questionType' => 'exists:question_types,name|required_if:postType,=,3',
            'classwork.answer' => 'required_if:classwork.questionType,=,2,3',
            'classwork.correctAnswerIndex' => 'integer|nullable',
        ];

    }
}
