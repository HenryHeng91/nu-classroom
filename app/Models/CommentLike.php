<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    public function comment(){
        return $this->belongsTo('App\Models\Comment');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
