<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentResource extends JsonResource
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
            'postId' => $this->post->guid,
            'submitCount' => $this->submit_count,
            'submits' => $this->assignmentSubmits,
            'startDate' => $this->start_date,
            'endDate' => $this->end_date,
            'file' => $this->file,
            'createDate' => $this->created_at,
            'updateDate' => $this->updated_at
        ];
    }
}
