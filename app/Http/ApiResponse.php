<?php

namespace App\Http;

use Illuminate\Http\Response as HttpResponse;

class ApiResponse extends HttpResponse {

    protected static $defaultErrorMessage = "Error";
    protected static $defaultServerErrorMessage = 'Server error';

    public static function error($message = null
    , $status = 400
    , array $body = []) {
        if ($message === null) {
            if ($status === 500) {
                $message = static::$defaultServerErrorMessage;
            } else {
                $message = static::$defaultErrorMessage;
            }
        }
        $body['message'] = $message;
        return self::create($body, $status);
    }

    public static function success($message, $status = 200, $body = []) {
        $body['message'] = $message;
        return self::create($body, $status);
    }

}
