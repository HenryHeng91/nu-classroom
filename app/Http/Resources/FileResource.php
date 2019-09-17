<?php

namespace App\Http\Resources;

use App\Http\Controllers\Enums\AccessEnum;
use App\Http\Controllers\Enums\StatusEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
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
            'displayName' => $this->display_name,
            'description' => $this->description,
            'userId' => $this->user->guid,
            'source' => $this->source,
            'fileExtention' => $this->file_extention,
            'fileName' => $this->file_name,
            'access' => AccessEnum::getEnumName($this->access),
            'status' => StatusEnum::getEnumName($this->status),
            'createdAt' => $this->created_at
        ];

    }
}
