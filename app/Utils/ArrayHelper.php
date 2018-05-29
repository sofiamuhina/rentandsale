<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Model;

class ArrayHelper {

    public static function removeEqualAttributes($array, Model $model) {
        if (empty($array)) {
            return [];
        }
        foreach ($array as $key => $value) {
            if (in_array($key, array_keys($model->getAttributes())) &&
                    $model->getOriginal($key) === $value) {
                unset($array[$key]);
            }
        }
        if (empty($array)) {
            return false;
        }
        return $array;
    }

}
