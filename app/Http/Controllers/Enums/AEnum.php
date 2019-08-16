<?php


namespace App\Http\Controllers\Enums;


use ReflectionClass;

class AEnum
{
    public static function getEnumName($id){
        $refl = new ReflectionClass(static::class);
        $constatns = $refl->getConstants();
        return array_search($id, $constatns);

    }
}
