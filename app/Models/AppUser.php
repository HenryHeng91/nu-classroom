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

    public function posts(){
        return $this->hasMany('App\Models\Post', 'user_id', 'id');
    }

    public function createdClasses(){
        return $this->hasMany('App\Models\VirtualClass', 'instructor_id', 'id');
    }

    public function joinClasses(){
        return $this->belongsToMany('App\Models\VirtualClass', 'classes_students', 'user_id', 'class_id');
    }

    public function classmates(){
        $joinClassesIds = ClassesStudent::where('user_id', $this->id)->pluck('class_id');
        return AppUser::join('classes_students', 'app_users.id', '=', 'classes_students.user_id')
            ->join('virtual_classes', 'classes_students.class_id', '=', 'virtual_classes.id')
            ->where('app_users.id', '<>', $this->id)
            ->whereIn('virtual_classes.id', $joinClassesIds)->get();
    }
}
