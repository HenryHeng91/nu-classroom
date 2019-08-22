<?php

namespace App\Models;

use App\Http\Controllers\Enums\AccessEnum;
use App\Http\Controllers\Enums\StatusEnum;
use ContextHelper;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;
use Illuminate\Support\Facades\URL;

class VirtualClass extends Model
{
    /**
     * VirtualClass constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->url = URL::to('/api/v1/classes/'.uniqid().'/join');
        $this->access = AccessEnum::PUBLIC;
        $this->status = StatusEnum::ACTIVE;
        $this->start_date = now();
        $this->color = '#'.dechex(rand(0x000000, 0xFFFFFF));
        $this->guid = uniqid();
        $this->classBackgrounds_id = 1;

    }

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
        return $this->belongsTo('App\Models\ClassBackground', 'classBackgrounds_id', 'id');
    }

    public static function getAllClasses($userId){
        return self::where('instructor_id', $userId)->orWhereHas('students', function ($query) use ($userId){
            $query->where('guid', $userId);
        })->orderByDesc('created_at');
    }
}
