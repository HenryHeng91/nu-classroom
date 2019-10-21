<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassBackgroundResource extends JsonResource
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
            'name' => $this->name,
            'file' => $this->file->source,
            'category' => $this->category,
            'createDate' => $this->created_at,
            'updateDate' => $this->updated_at
        ];
    }
}
