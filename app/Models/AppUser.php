<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppUser extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'username',
        'password',
        'first_name',
        'last_name',
        'gender',
        'birth_date',
        'email',
        'phone',
        'address',
        'city',
        'country',
        'self_description',
        'education_level'
    ];

    public function createdClasses(){
        return $this->hasMany('App\Models\VirtualClass', 'instructor_id', 'id');
    }

    public function joinClasses(){
        return $this->belongsToMany('App\Models\VirtualClass', 'classes_students', 'user_id', 'class_id');
    }
}
