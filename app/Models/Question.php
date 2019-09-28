<?php

namespace App\Models;

use App\Http\Controllers\Enums\QuestionTypeEnum;
use App\Http\Requests\PostCreateRequest;
use App\Services\ClassworkServices\Dto\CreateAnswerDto;
use App\Services\ClassworkServices\Dto\CreateQuestionDto;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function post(){
        return $this->hasOne('App\Models\Post', 'classwork_id', 'id');
    }

    public function exam(){
        return $this->belongsTo('App\Models\Exam');
    }

    public function answers(){
        return $this->hasMany('App\Models\Answer');
    }

    public function userAnswers(){
        return $this->hasMany('App\Models\UserAnswer');
    }

    /**
     * Convert request of questions to array of questions
     *
     * @param PostCreateRequest $request
     * @return array
     */
    public static function getQuestionsFromRequest($questionDtosArray): array
    {
        $questions = array();
        foreach ($questionDtosArray as $q) {
            $questionType = QuestionTypeEnum::getEnumByName($q['questionType']);

            $question = new Question();
            $question->title = $q['title'];
            $question->description = $q['description'];
            $question->question_type = $questionType;
            $question->point = 0;
            $question->guid = uniqid();

            if ($questionType == QuestionTypeEnum::TRUE_FALSE || $questionType == QuestionTypeEnum::MULTI_CHOICE){
                $answers = Question::getAnswersFromRequest($q['answer'], $q['questionType']);
                $question->answers()->saveMany($answers);
            }

            array_push($questions, $question);
        }
        return $questions;
    }


    /**
     * Convert request dto into answer dto
     *
     * @param PostCreateRequest $request
     */
    public static function getAnswersFromRequest($answerDto, $questionType): array
    {
        $answers = array();
        $questionType = QuestionTypeEnum::getEnumByName($questionType);

        $correctAnswerIndex = $answerDto['correctAnswerIndex'];
        if ($questionType == QuestionTypeEnum::TRUE_FALSE){
            $answers = Answer::createTrueFalseAnswer($correctAnswerIndex);
        }

        if ($questionType == QuestionTypeEnum::MULTI_CHOICE){
            foreach ($answerDto['items'] as $k => $a){
                $answer = new Answer();
                $answer->answer_detail = $a['answerDetail'];
                $answer->answer_order = $k;
                $answer->is_correct = $k == $correctAnswerIndex;
                $answer->guid = uniqid();
                array_push($answers, $answer);
            }
        }

        return $answers;
    }

}
