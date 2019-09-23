<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function question(){
        return $this->belongsTo('App\Models\Question');
    }

    /**
     * Return a true and false answers
     *
     * @param $correctAnswerIndex
     * @return array
     */
    public static function createTrueFalseAnswer($correctAnswerIndex): array
    {
        $arrayChoice = ['True', 'False'];
        $answers = array();
        for ($i = 0; $i < 2; $i++){
            $answer = new Answer();
            $answer->answer_detail = $arrayChoice[$i];
            $answer->answer_order = $i;
            $answer->is_correct = $i == $correctAnswerIndex;
            $answer->guid = uniqid();
            array_push($answers, $answer);
        }

        return $answers;
    }
}
