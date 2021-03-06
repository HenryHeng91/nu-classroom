<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    public function user(){
        return $this->belongsTo('App\Models\AppUser', 'user_id');
    }

    public function post(){
        return $this->belongsTo('App\Models\Post');
    }

    public function file(){
        return $this->hasOne('App\Models\File', 'id', 'file_id');
    }

    public function likes(){
        return $this->hasMany('App\Models\CommentLike');
    }
}
