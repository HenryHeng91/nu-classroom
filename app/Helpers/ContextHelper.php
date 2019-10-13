<?php


use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ContextHelper {
    /**
     * @var \Illuminate\Database\Eloquent\Collection|static[]
     */
    private static $Statuses;


    /**
     * ContextHelper constructor.
     */
    public function __construct()
    {
        $this->Statuses = \App\Models\Status::all();
    }

    public static function GetStatus($statusId){
        return self::$Statuses->where('id', $statusId);
    }

    public static function GetRequestUserId(){
        return \App\Models\AppUser::where('guid', Request::input('NU_CLASSROOM_USER.userId'))->first()->id;
    }

    public static function ToSnakeCase($json)
    {
        foreach($json as $key => $value)
        {
            $return[Str::snake($key)] = $value;
        }

        return $return;
    }
}
