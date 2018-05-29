<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Utils\InputFilter;
use App\Utils\Utils;
use App\Http\Controllers\Auth\ApiLoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\ApiResponse;

class RegisterController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/users';
    protected $isApi = false;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('registerFromAdmin');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return User::getValidatorCreate($data);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {
        $userData = $data;
        $userData['password'] = bcrypt($userData['password']);
        if (isset($userData['firstname'])) {
            $userData['name'] = $userData['firstname'];
        }

        $userData = array_filter($userData);

        $user = User::create($userData);

        $thisUser = Auth::guard('web')->user();

        
        return $user;
    }

    public function registerFromAdmin(Request $request) {
        
        $userData['name'] = $request->name;
        $userData['email'] = $request->email;
        $userData['password'] = $request->password;
        $userData['phone'] = $request->phone;
        $user = $this->create($userData);
        
        if (!empty($request->roles)) {  
            $roles = $request->roles;
            foreach ($roles as $role) {
                $user_role = new UserRole;
                $user_role->role_id = $role;
                $user_role->user_id = $user['id'];
                $user_role->save();
            }
        }
        return redirect()->route('userlist');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request) {
        $this->isApi = Utils::isApi($request);
        $params = $request->all();
        if (!is_array($params)) {
            $params = [];
        }
        $userData = InputFilter::filterArray(
                        $params, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if ($request->hasFile('avatar')) {
            $userData['avatar'] = $request->file('avatar');
        }
        
        $this->validator($userData)->validate();

        try {
            event(new Registered($user = $this->create($userData)));
        } catch (\Exception $ex) {
            if ($this->isApi) {
                return ApiResponse::error('Registration failed', 400
                                , ['params' => $userData
                            , 'exMessage' => $ex->getMessage()]);
            } else {
                return redirect($this->redirectPath())
                                ->withErrors([$ex->getMessage()]);
            }
        }

        if ($this->isApi) {
            if (count($user) > 0) {
                $result = (new ApiLoginController($request))->apiAuthArray($userData);
            } else {
                $result = ApiResponse::error('Registration failed', 400
                                , ['params' => $userData]);
            }
        } else {
            if ($this->registered($request, $user)) {
                $result = redirect($this->redirectPath());
            } else {
                $result = redirect($this->redirectPath());
            }
        }
        return $result;
    }

}
