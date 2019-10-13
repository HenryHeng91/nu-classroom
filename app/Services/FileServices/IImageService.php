<?php

namespace App\Services\FileServices;
interface IImageService
{
    /**Save an image to specific path
     *
     * @param $imageFile = Image file to be saved
     * @param $destinationPath = Destination path to be saved
     * @param string $imagePrefix = Prefix name of the image
     * @return string
     */
    public function SaveImageToPath($imageFile, $destinationPath, $imagePrefix = '');

}
