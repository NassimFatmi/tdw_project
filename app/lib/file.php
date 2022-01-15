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
    private function _saveImage($id, $filePrefix, $path)
    {
        $file = $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];
        $fileExt = explode('.', $fileName);
        $fileAcctualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png');
        if (in_array($fileAcctualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 5000000) {
                    $fileNewName = $filePrefix . '_' . $id . '.' . $fileAcctualExt;
                    $fileDestination = PUBLIC_FOLDER . DS . 'uploads' . DS . $path . DS . $fileNewName;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    unset($_FILES);
                    return true;
                } else {
                    $_SESSION['errorMessage'] = 'Votre fichier est trop large.';
                    return false;
                }
            } else {
                $_SESSION['errorMessage'] = 'Il y a un error lors le telechargement de votre fichier';
                return false;
            }
        } else {
            $_SESSION['errorMessage'] = 'On accepte pas ce type de ficher.';
            return false;
        }
    }
}