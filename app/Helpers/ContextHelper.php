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

    /**Save an image to specific path
     *
     * @param $imageFile = Image file to be saved
     * @param $destinationPath = Destination path to be saved
     * @param string $imagePrefix = Prefix name of the image
     * @return string
     */
    public static function SaveImageToPath($imageFile, $destinationPath, $imagePrefix = ''){
        $defaultHeight = env('IMAGE_DEFAULT_HEIGHT');
        $filename = $imagePrefix.uniqid().'.'.$imageFile->getClientOriginalExtension();
        $imageFile = Image::make($imageFile->getRealPath())->resize(null, $defaultHeight, function ($constraint){
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $imageFile->save($destinationPath . $filename);
        return $filename;
    }

}
