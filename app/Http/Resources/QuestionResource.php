<?php

namespace App\Http\Resources;

use App\Http\Controllers\Enums\QuestionTypeEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'questionType' => QuestionTypeEnum::getEnumName($this->question_type),
            'answers' => AnswerResource::collection($this->answers),
            'studentAnswers' => UserAnswerResource::collection($this->userAnswers),
            'postId' => $this->post->guid ?? null,
            'examId' => $this->exam->guid ?? null,
            'createDate' => $this->created_at,
            'updateDate' => $this->updated_at
        ];
    }
}
