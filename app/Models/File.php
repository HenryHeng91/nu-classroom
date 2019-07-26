<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
