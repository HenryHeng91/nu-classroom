<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    public function post(){
        return $this->hasOne('App\Models\Post');
    }

    public function file(){
        return $this->hasOne('App\Models\File');
    }

    public function questions(){
        return $this->hasMany('App\Models\Question');
    }

    public function examSubmits(){
        return $this->hasMany('App\Models\ExamSubmit');
    }
}
