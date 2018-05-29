<?php

namespace App\Utils;

use App\Utils\DistanceCalculator;

class DistanceCalcHelper {

    /**
     * Removes long/lat/radius params from incoming array and 
     * returns them in new array
     * 
     * @param &$array
     */
    public static function cutZoneParams(&$array) {
        $result = [];
        if (isset($array['longitude']) &&
                isset($array['latitude']) &&
                isset($array['radius'])) {
            $result['longitude'] = $array['longitude'];
            $result['latitude'] = $array['latitude'];
            $result['radius'] = $array['radius'];
        }
        unset($array['longitude']);
        unset($array['latitude']);
        unset($array['radius']);
        return $result;
    }

    public static function filterCollection($list, $params) {
        $params['latitudeParamName'] = isset($params['latitudeParamName']) ?
                $params['latitudeParamName'] : 'latitude';
        $params['longitudeParamName'] = isset($params['longitudeParamName']) ?
                $params['longitudeParamName'] : 'longitude';


        foreach ($list as $key => $element) {
            if (!isset($element->{$params['latitudeParamName']}) ||
                    !isset($element->{$params['longitudeParamName']})) {
                $list->forget($key);
                continue;
            }

            $distance = DistanceCalculator::calcBetween($params['latitude']
                            , $params['longitude']
                            , $element->{$params['latitudeParamName']}
                            , $element->{$params['longitudeParamName']});

            if ($distance > $params['radius']) {
                $list->forget($key);
            }
        }

        return $list;
    }

}
