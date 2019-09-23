<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    /**
     * Exam constructor.
     */
    public function __construct()
    {
        $this->submit_count = 0;
        parent::__construct();
    }

    public function post(){
        return $this->hasOne('App\Models\Post', 'classwork_id', 'id');
    }

    public function file(){
        return $this->hasOne('App\Models\File', 'id', 'file_id');
    }

    public function questions(){
        return $this->hasMany('App\Models\Question', 'exam_id', 'id');
    }

    public function examSubmits(){
        return $this->hasMany('App\Models\ExamSubmit');
    }
}
