<?php

namespace App\Models;

use ContextHelper;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;

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

    public static function getAllClasses($userId){
        return self::where('instructor_id', $userId)->orWhereHas('students', function ($query) use ($userId){
            $query->where('guid', $userId);
        })->orderByDesc('created_at');
    }
}
