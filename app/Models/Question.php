<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function exam(){
        return $this->belongsTo('App\Models\Exam');
    }

    public function answers(){
        return $this->hasMany('App\Models\Answer');
    }

    public function userAnswers(){
        return $this->hasMany('App\Models\UserAnswer');
    }
}
