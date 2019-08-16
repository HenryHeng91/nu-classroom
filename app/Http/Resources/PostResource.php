<?php

namespace App\Http\Resources;

use App\Http\Controllers\Enums\PostTypeEnum;
use App\Http\Controllers\Enums\StatusEnum;
use App\Models\Status;
use App\Http\Controllers\Enums\AccessEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'detail' => $this->detail,
            'user' => $this->user,
            'class' => $this->class,
            'access' => AccessEnum::getEnumName($this->access),
            'postType' => PostTypeEnum::getEnumName($this->post_type),
            'classwork' => $this->classWorks,
            'status' => StatusEnum::getEnumName($this->status),
            'viewCount' => $this->view_counts,
            'likeCount' => $this->like_count,
            'commentCount' => $this->comments->count(),
            'file' => $this->file,
            'createDate' => $this->created_at,
            'lastUpdateDate' => $this->updated_at,
        ];
    }
}
