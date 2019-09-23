<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
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
            'questionID' => $this->question->guid,
            'answerDetail' => $this->answer_detail,
            'answerOrder' => $this->answer_order,
            'isCorrect' => $this->is_correct,
            'createDate' => $this->created_at
        ];

    }
}
