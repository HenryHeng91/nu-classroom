<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'id'            => $this->guid,
            'user' => new FriendUserResource($this->user),
            'postId' => $this->post->guid,
            'commentDetail' => $this->comment_detail,
            'likeCount' => $this->like_count,
            'fileId' => new FileResource($this->file),
            'createDate' => $this->created_at,
            'lastUpdateDate' => $this->updated_at,
        ];
    }
}
