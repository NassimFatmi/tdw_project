<?php

namespace TDW\LIB;

trait File
{
    public static function searchFile($folder, $prefix, $id)
    {
        $filePath = '/uploads/' . $folder . '/' . $prefix . '_' . $id;
        $fileRealPath = PUBLIC_FOLDER . DS . 'uploads' . DS . $folder . DS . $prefix . '_' . $id;
        if (file_exists($fileRealPath . '.jpg')) {
            return $filePath . '.jpg';
        } elseif (file_exists($fileRealPath . '.png')) {
            return $filePath . '.png';
        } elseif (file_exists($fileRealPath . '.jpeg')) {
            return $filePath . '.jpeg';
        } else {
            return '/assets/images/image_place_holder.png';
        }
    }
}