<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\ApiResponse;
use App\Http\Request;
use App\Utils\Utils;
//use App\Models\Services\BaseService;

class Controller extends BaseController {

    /**
     * @var User
     */
    protected $user;

    /**
     * @var ApiResponse
     */
    protected $response;
    
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request = null) {
        $this->user = Auth::guard('api')->user();
        $this->response = new ApiResponse();
        $this->request = $request;
    }

    protected function modelNotFound() {
        return $this->response->error('Entity not found');
    }
    
    protected static function throwException($message, $data = null) {
        Utils::throwGenericEx($message, $data);
    }

    /*public function getList() {
        $list = $this->repository->all();
        
        return $list;
    }

    public function get($id) {
        
    }

    public function create() {
        
    }

    public function update($id) {
        
    }

    public function delete($id) {
        
    }
    
    protected function forbidden() {
        return $this->response->error('Access denied', 403);
    }*/

}
