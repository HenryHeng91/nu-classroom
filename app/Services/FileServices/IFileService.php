<?php

namespace App\Services\FileServices;

interface IFileService
{
    public function saveUserFile($file, $filename);
    public function saveMaterialFile($file, $filename);


}
