<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function user(){
        return $this->belongsTo('App\Models\AppUser', 'user_id');
    }

    public function post(){
        return $this->belongsTo('App\Models\Post');
    }

    public function file(){
        return $this->hasOne('App\Models\File');
    }

    public function likes(){
        return $this->hasMany('App\Models\CommentLike');
    }
}
