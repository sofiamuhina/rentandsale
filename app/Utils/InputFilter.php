<?php

namespace App\Utils;

class InputFilter {

    /**
     * Returns array of values from selected input and 
     * filtered with specified filter type.
     * If paramNames has a key, then this key will be uses as index in
     * resulting array, otherwise paramName value will be a key.
     * 
     * @param array $paramNames
     * @param int $inputType
     * @param int $filterType
     * @return boolean
     */
    public static function filterInputArray($paramNames, $inputType, $filterType) {
        $result = [];
        foreach ($paramNames as $key => $value) {
            $paramName = is_string($key) ? $key : $value;
            $result[$paramName] = filter_input($inputType, $value, $filterType);
        }
        if (count($result) === 0) {
            $result = false;
        }
        return $result;
    }

    /**
     * Applies filter var to each element of array
     * 
     * @param array $array
     * @param int $filterType
     * @return boolean
     */
    public static function filterArray($array, $filterType, $options = null) {
        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result[$key] = self::filterArray(
                                $value, $filterType, $options);
            } else {
                $result[$key] = filter_var($value, $filterType, $options);
            }
        }
        return $result;
    }

}
