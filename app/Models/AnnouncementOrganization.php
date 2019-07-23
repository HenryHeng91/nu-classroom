<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnouncementOrganization extends Model
{
    public function organization(){
        return $this->belongsTo('App\Models\Organization', 'org_id');
    }

    public function viewers(){
        return $this->belongsToMany('App\User', 'announcement_organizatoins_views', 'announcementorganizatoins_id', 'user_id');
    }

    public function file(){
        return $this->hasOne('App\Models\File');
    }
}
