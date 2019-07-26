<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnouncementClass extends Model
{
    public function class(){
        return $this->belongsTo('App\Models\VirtualClass', 'class_id');
    }

    public function viewers(){
        return $this->belongsToMany('App\User', 'announcement_classes_views', 'announcementclasses_id', 'user_id');
    }

    public function file(){
        return $this->hasOne('App\Models\File');
    }


}
