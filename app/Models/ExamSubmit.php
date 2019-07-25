<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSubmit extends Model
{
    public function exam(){
        return $this->belongsTo('App\Models\Exam');
    }
}
