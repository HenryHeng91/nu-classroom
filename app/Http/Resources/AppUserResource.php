<?php

namespace App\Http\Resources;

use App\Models\Status;
use ContextHelper;
use HttpResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class AppUserResource extends JsonResource
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
            'username'      => $this->username,
            'profilePicture'=> asset(env('AVATAR_PATH')).'/'.$this->profile_pic,
            'accessToken'   => $this->access_token,
            'firstName'     => $this->first_name,
            'lastName'      => $this->last_name,
            'gender'        => $this->gender,
            'birthDate'     => $this->birth_date,
            'email'         => $this->email,
            'phone'         => $this->phone,
            'address'       => $this->address,
            'city'          => $this->city,
            'country'       => $this->country,
            'selfDescription'   => $this->self_description,
            'educationLevel'   => $this->education_level,
            'status'        => Status::find($this->status)->name,
            'CreatedClasses' => VirtualClassResource::collection($this->createdClasses),
            'JoinedClasses' => VirtualClassResource::collection($this->joinClasses),
            'signUpDate'    => $this->created_at,
        ];
    }
}
