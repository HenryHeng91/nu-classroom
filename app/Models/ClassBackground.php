<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassBackground extends Model
{
    public function file(){
        return $this->hasOne('App\Models\File', 'id', 'file_id');
    }

    public function category(){
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }

}
