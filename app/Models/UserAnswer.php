<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    public function question(){
        return $this->belongsTo('App\Models\Question');
    }

    public function chosenAnswer(){
        return $this->hasOne('App\Models\Answer', 'id', 'answer_id');
    }
}
