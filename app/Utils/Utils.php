<?php

namespace App\Utils;

use Illuminate\Http\Request;
use App\Exceptions\GenericException;

class Utils {

    public static function isApi(Request $request) {
        return $request->is('api/*');
    }
    
    public static function throwGenericEx($message, $data = null) {
        $ex = new GenericException($message);
        $ex->setData($data);
        throw $ex;
    }

}
