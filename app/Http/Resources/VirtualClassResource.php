<?php

namespace App\Http\Resources;

use App\Http\Controllers\Enums\AccessEnum;
use App\Http\Controllers\Enums\StatusEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class VirtualClassResource extends JsonResource
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
            'classTitle' => $this->class_title,
            'description' => $this->description,
            'instructor' => $this->instructor,
            'url' => $this->url,
            'category' => $this->category,
            'access' => AccessEnum::getEnumName($this->access),
            'status' => StatusEnum::getEnumName($this->status),
            'membersCount' => $this->members_count,
            'organization' => $this->organization,
            'startDate' => $this->start_date,
            'endDate' => $this->end_date,
            'classStartTime' => $this->class_start_time,
            'classEndTime' => $this->class_end_time,
            'classDays' => array_map ('intval', explode(",", $this->class_days)),
            'color' => $this->color,
            'createdDate' => $this->created_at,
            'lastUpdateDate' => $this->updated_at,
            'background' => $this->classBackground,
        ];
    }
}
