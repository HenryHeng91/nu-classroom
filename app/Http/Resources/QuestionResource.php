<?php

namespace App\Http\Resources;

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
            'postId' => $this->post->guid ?? null,
            'createDate' => $this->created_at,
            'updateDate' => $this->updated_at
        ];
    }
}
