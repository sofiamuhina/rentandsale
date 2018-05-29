<?php

namespace App\Models\Services;

use App\Http\Request;
use App\Models\Repositories\BaseRepository;
use App\Exceptions\MessageException;
use Illuminate\Support\Facades\Auth;
use App\Utils\Utils;
use App\Models\User;

/* use App\Models\Repositories\Criteria\Distinct;
  use App\Models\Repositories\Criteria\Select;
  use App\Models\Repositories\Criteria\In;
  use App\Models\Repositories\Criteria\DateCriteria;
  use App\Models\Repositories\Criteria\Where;
  use Illuminate\Pagination\Paginator; */

abstract class BaseService {

    use \App\Traits\GetList {
        getList as public getListParent;
    }

    /**
     *
     * @var Request
     */
    protected $request;

    /**
     *
     * @var BaseRepository
     */
    protected $repository;

    /**
     *
     * @var MessageException
     */
    //protected static $genericException = MessageException::class;

    /**
     *
     * @var User
     */
    protected $user;

    public function __construct(Request $request = null, BaseRepository $repository = null) {
        $guard = null;
        if (Auth::guard('web')->check()) {
            $guard = 'web';
        } elseif (Auth::guard('api')->check()) {
            $guard = 'api';
        }
        $this->user = Auth::guard($guard)->user();
        $this->request = $request;
        $this->repository = $repository;
    }

    /*public function getList($params = null) {
        return $this->getListParent($params);
    }*/

    protected static function throwException($message, $data = null) {
        Utils::throwGenericEx($message, $data);
    }

}
