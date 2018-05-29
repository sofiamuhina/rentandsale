<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;

trait HasValidators {

    protected static $validatorCreateParams = [];
    protected static $validatorUpdateParams = [];

    /**
     * 
     * @param type $data
     * @return Validator
     */
    public static function getValidatorCreate($data) {
        return Validator::make($data, static::$validatorCreateParams);
    }

    /**
     * 
     * @param type $data
     * @return Validator
     */
    public static function getValidatorUpdate($data) {
        return Validator::make($data, static::$validatorUpdateParams);
    }

    /**
     * 
     * @return array
     */
    public static function getValidatorCreateParams() {
        return static::$validatorCreateParams;
    }

    /**
     * 
     * @return array
     */
    public static function getValidatorUpdateParams() {
        return static::$validatorUpdateParams;
    }

}
