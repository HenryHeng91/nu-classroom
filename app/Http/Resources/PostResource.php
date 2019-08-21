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
            'user' => new FriendUserResource($this->user),
            'class' => new VirtualClassResource($this->class),
            'access' => AccessEnum::getEnumName($this->access),
            'postType' => PostTypeEnum::getEnumName($this->post_type),
            'classwork' => self::GetClassWorkResource($this),
            'status' => StatusEnum::getEnumName($this->status),
            'viewCount' => $this->view_counts,
            'viewers' => FriendUserResource::collection($this->viewers),
            'likeCount' => $this->like_count,
            'likers' => FriendUserResource::collection($this->likers),
            'commentCount' => $this->comments->count(),
            'file' => $this->file,
            'createDate' => $this->created_at,
            'lastUpdateDate' => $this->updated_at,
        ];
    }

    function GetClassWorkResource($post){
        switch ($post->post_type){
            case PostTypeEnum::ASSIGNMENT:
                return new AssignmentResource($post->classWorks());
            case PostTypeEnum::EXAM:
                return new ExamResource($post->classWorks());
            case PostTypeEnum::QUESTION:
                return new QuestionResource($post->classWorks());
            case PostTypeEnum::POST:
            default:
                return null;
        }
    }
}
