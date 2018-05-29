<?php

namespace App\Utils;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FileHelper {

    /**
     * 
     * @param UploadedFile $file
     * @param string $folderPath
     * @param string $previousFile The string with previous file
     * @param array $params only file name     
     * @return string hashName
     */
    public static function saveFile(UploadedFile $file, $folderPath
    , $previousFile, $params = []) {
        if ($previousFile) {
            \Storage::delete($folderPath . "/$previousFile");
        }
        $prefix = isset($params['prefix']) ? $params['prefix'] : '';

        $fileName = $prefix . $file->hashName();
        /*  while (file_exists($folderPath . "/$fileName")) {//collisions
          $fileName = Str::random(40);
          } */

        if (isset($params['publicly']) && $params['publicly'] === false) {
            $file->store($folderPath, $fileName);
        } else {
            $file->storePubliclyAs($folderPath, $fileName);
        }

        return $fileName;
    }

    public static function deleteFile($fileName, $folderPath = '') {
        return \Storage::delete($folderPath . "/$fileName");
    }

}
