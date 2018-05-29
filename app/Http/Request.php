<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http;

use Illuminate\Http\Request as RequestBase;
use App\Utils\InputFilter;

class Request extends RequestBase {

    public function __construct(array $query = array()
    , array $request = array()
    , array $attributes = array()
    , array $cookies = array()
    , array $files = array()
    , array $server = array()
    , $content = null) {
        parent::__construct($query, $request, $attributes
                , $cookies, $files, $server, $content);
    }

    /**
     * 
     * @param boolean $sanitize
     * @return array
     */
    public function all($sanitize = false) {
        $result = parent::all();

        if ($sanitize) {
            $result = InputFilter::filterArray(
                            $result, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES);
        }
        
        return $result;
    }

}
