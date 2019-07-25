<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnouncementUser extends Model
{
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function viewers(){
        return $this->belongsToMany('App\User', 'announcement_users_views', 'announcementusers_id', 'user_id');
    }

    public function file(){
        return $this->hasOne('App\Models\File');
    }
}
