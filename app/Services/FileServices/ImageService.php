<?php

namespace App\Services\FileServices;
use Exception;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ImageService implements IImageService
{

    public function SaveImageToPath($imageFile, $destinationPath, $imagePrefix = '')
    {
        $validator = Validator::make(array('image_file'=>$imageFile), ['image_file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:10240']);
        if ($validator->fails()){
            throw new Exception('Error reading image. The image should be in type jpg,png,jpeg,gif,svg and maximum size only is 10MB.');
        }

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
