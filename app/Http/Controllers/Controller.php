<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Request;
use App\Utils\Utils;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    /**
     *
     * @var User
     */
    protected $user;

    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request = null) {
        $this->request = $request;
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (!empty($user)) {
                View::share('currentUser', $user);
                $this->user = $user;
            }

            return $next($request);
        });
    }
    
    protected static function throwException($message, $data = null) {
        Utils::throwGenericEx($message, $data);
    }

}
