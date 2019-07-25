<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentSubmit extends Model
{
    public function assignment(){
        return $this->belongsTo('App\Models\Assignment');
    }

    public function file(){
        return $this->hasOne('App\Models\File');
    }
}
