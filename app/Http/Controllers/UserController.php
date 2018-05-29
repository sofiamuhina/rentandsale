<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Models\User;
use App\Utils\InputFilter;
use App\Utils\ArrayHelper;
use App\Models\Role;
use App\Models\Services\UserService;

class UserController extends Controller {

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    function userlist() {
        $users = User::orderBy('created_at', 'asc')->get();

        return view('users.userlist', [
            'users' => $users
        ]);
    }

    /**
     * Create new user
     *
     * @param  Request  $request
     * @return Response
     */
    function create(Request $request) {
        $this->validate($request, [
            'firstname' => 'required|max:255',
        ]);
        
        $user = new User;
        $user->name = $request->firstname;
        $user->email = $request->email;
        $user->password = $request->password;
        $id_user = $user->save();
        

        return redirect()->route('userlist');
    }

    function get($id = null) {
        try {
            $user = self::getByIdOrAuth($id);
        } catch (\Exception $ex) {
            return self::redirectNotExists();
        }

        return view('users.profile', [
            'user' => $user
        ]);
    }

    public function update(Request $request, $id) {
        $userData = InputFilter::filterArray(
                        $request->all(), FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (empty($request->password)) {
            unset($userData['password']);
        }

        try {
            $user = self::getByIdOrAuth($id);
        } catch (\Exception $ex) {
            return self::redirectNotExists();
        }

        $userData = array_filter($userData);
        $userData = ArrayHelper::removeEqualAttributes($userData, $user);

        if (isset($userData['firstname'])) {
            $userData['name'] = $userData['firstname'];
        }

        User::getValidatorUpdate($userData)->validate();

        if (isset($userData['password'])) {
            $userData['password'] = bcrypt($userData['password']);
        }


        $user->update($userData);

        return redirect()->route('user', [$user]);
    }

    public function delete(Request $request, $id) {
        if (isset($this->user)) {
            User::findOrFail($id)->delete();
            return redirect()->route('userlist');
        }
        return redirect()->route('userlist')
                        ->withErrors('Недостаточно прав для данного действия');
    }

    private static function redirectNotExists() {
        return redirect()->route('userlist')
                        ->withErrors(['Данный пользователь не существует']);
    }

    private function getByIdOrAuth($id) {
        if (empty($id)) {
            $user = $this->user;
        } else {
            $user = User::findOrFail($id);
        }
        return $user;
    }

}
