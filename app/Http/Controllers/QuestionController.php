<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Enums\QuestionTypeEnum;
use App\Http\Requests\SubmitQuestionRequest;
use App\Models\Answer;
use App\Models\AppUser;
use App\Models\Question;
use App\Models\UserAnswer;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }

    /**
     * Submit answer
     *
     * @param SubmitQuestionRequest $request
     * @return void
     */
    public function submitAnswer(SubmitQuestionRequest $request)
    {
        $user = AppUser::find(\ContextHelper::GetRequestUserId());
        $questionId = $request->input('questionId');
        $question = Question::where('guid', $questionId)->first();

        if(!$question->post->class->students->contains($user)){
            return response("This user doesn't have right to answer this question with id '$questionId'", 400);
        }

        $userAnswer = new UserAnswer();
        $userAnswer->guid = uniqid();
        $userAnswer->question_id = $question->id;
        $userAnswer->user_id = $user->id;

        switch (QuestionTypeEnum::getEnumByName($request->input('questionType'))){
            case QuestionTypeEnum::WRITE:
                $userAnswer->answers_detail = $request->input('answer.answerDetail');
                break;
            case QuestionTypeEnum::TRUE_FALSE:
            case QuestionTypeEnum::MULTI_CHOICE:
                $userAnswerIndex = $request->input('answer.userAnswerIndex');
                $answer = Answer::where('question_id', $question->id)->where('answer_order', $userAnswerIndex)->first();
                $userAnswer->answer_id = $answer->id;
                $userAnswer->isCorrect = $answer->is_correct;
                break;
        }

        $question->userAnswers()->save($userAnswer);
        return response("OK", 200);
    }


}
