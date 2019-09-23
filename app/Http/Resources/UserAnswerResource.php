<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->guid,
            'questionId' => $this->question->guid,
            'answerId' => $this->chosenAnswer->guid,
            'answersDetail' => $this->answers_detail,  // in case of writing question, then there has no answerId, then we use answers detail instead
            'isCorrect' => $this->isCorrect,  //given by the teacher or decide by the isCorrect boolean on the chosen answer
            'createDate' => $this->created_at,
            'updateDate' => $this->updated_at
        ];

    }
}
