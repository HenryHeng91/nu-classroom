<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VirtualClass extends Model
{
    public function instructor(){
        return $this->belongsTo('App\Models\AppUser', 'instructor_id', 'id');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function organization(){
        return $this->belongsTo('App\Models\Organization');
    }

    public function students(){
        return $this->belongsToMany('App\Models\AppUser', 'classes_students', 'class_id', 'user_id');
    }

    public function classBackground(){
        return $this->belongsTo('App\Models\ClassBackground');
    }
}
