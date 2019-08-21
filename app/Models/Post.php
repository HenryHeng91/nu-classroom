<?php

namespace App\Models;

use App\Http\Controllers\Enums\PostTypeEnum;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user(){
        return $this->belongsTo('App\Models\AppUser', 'user_id');
    }

    public function class(){
        return $this->belongsTo('App\Models\VirtualClass', 'class_id');
    }

    public function classWorks(){
        switch ($this->post_type){
            case PostTypeEnum::ASSIGNMENT:
                return Assignment::find($this->classwork_id);
            case PostTypeEnum::EXAM:
                return Exam::find($this->classwork_id);
            case PostTypeEnum::QUESTION:
                return Question::find($this->classwork_id);
            default:
                return null;
        }
    }

    public function file(){
        return $this->hasOne('App\Models\File', 'id', 'file_id');
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
