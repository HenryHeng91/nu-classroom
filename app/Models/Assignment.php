<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    public function post(){
        return $this->hasOne('App\Models\Post');
    }

    public function file(){
        return $this->hasOne('App\Models\File');
    }

    public function assignmentSubmits(){
        return $this->hasMany('App\Models\AssignmentSubmit');
    }
}
