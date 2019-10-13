<?php

namespace App\Models;

use App\Http\Controllers\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * File constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->guid = uniqid();
        $this->status = StatusEnum::ACTIVE;
    }

    public function user(){
        return $this->belongsTo('App\Models\AppUser', 'user_id');
    }
}
