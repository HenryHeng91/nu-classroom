<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticEvent extends Model
{
    public function eventCode(){
        return $this->belongsTo('App\Models\EventCode', 'event_id');
    }
}
