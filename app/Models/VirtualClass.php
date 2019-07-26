<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VirtualClass extends Model
{
    public function instructor(){
        return $this->belongsTo('App\User', 'id', 'instructor_id');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function organization(){
        return $this->belongsTo('App\Models\Organization');
    }

    public function students(){
        return $this->belongsToMany('App\User', 'classes_students', 'class_id', 'user_id');
    }
}
