<?php

namespace App\Services\FileServices;

class FileService implements IFileService
{

    public function saveUserFile($file, $filename)
    {
        return $this->saveFile($file, self::getPathToSaveUserUpload(), $filename);
    }

    public function saveMaterialFile($file, $filename)
    {
        return $this->saveFile($file, self::getPathToSaveClassMaterial(), $filename);
    }

    private function getPathToSaveUserUpload(): string
    {
        return public_path(env('FILEPATH_USER'));
    }

    private function getPathToSaveClassMaterial(): string
    {
        return public_path(env('FILEPATH_MATERIAL'));
    }

    private function saveFile($file, $path, $filename)
    {
        return $file->move($path, $filename);
    }
}
