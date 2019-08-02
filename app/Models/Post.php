<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user(){
        return $this->belongsTo('App\Models\AppUser', 'user_id');
    }

    public function class(){
        return $this->belongsTo('App\Models\VirtualClass', 'class_id');
    }

    //todo: check if this relationship work inside switch logic, so we can do multiple relationship mapping with logic
    public function classWorks(){
        switch ($this->post_type){
            case 1:
                return $this->hasOne('App\Models\Assignment', 'post_id', 'classwork_id');
            case 2:
                return $this->hasOne('App\Models\Exam', 'post_id', 'classwork_id');
            default:
                return null;
        }
    }

    public function file(){
        return $this->hasOne('App\Models\File');
    }

    public function viewers(){
        return $this->belongsToMany('App\Models\AppUser', 'post_views', 'post_id', 'user_id');
    }

    public function likers(){
        return $this->belongsToMany('App\Models\AppUser', 'post_likes', 'post_id', 'user_id');
    }

    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }
}
