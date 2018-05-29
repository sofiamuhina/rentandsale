<?php

namespace App\Models\Repositories;

use App\Http\Request;
use Prettus\Repository\Eloquent\BaseRepository as Repository;
use App\Utils\Utils;

abstract class BaseRepository extends Repository {
    
    /**
     * @var Request
     */
    //protected $request;


    public function __construct(\Illuminate\Container\Container $app/*, Request $request*/) {
        parent::__construct($app);
        //$this->request = $request;
    }
    
    protected static function throwException($message, $data = null) {
        Utils::throwGenericEx($message, $data);
    }
    
    /**
     * Returns an array with parameters: 
     * page[size, number_current, number_max, objects]
     * Parameters for pagination are taken from request:
     * page[size, number]
     * 
     * @var $params Use to overwrite pagination params from request
     */
    public function getPaginatedArray($params) {
        
        
        
        
    }
}
