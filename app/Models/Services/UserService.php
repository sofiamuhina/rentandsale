<?php

namespace App\Models\Services;

use App\Http\Request;
use App\Utils\ArrayHelper;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Repositories\UserRepository;
use App\Models\PushSession;

class UserService extends BaseService {

    public function __construct(Request $request, UserRepository $repository) {
        parent::__construct($request, $repository);
    }
    
    public function get($id) {
        return $this->repository->find($id);
    }

    public function update($id) {
        $userData = $this->request->all();

        if (empty($request->password)) {
            unset($userData['password']);
        }

        $user = self::getByIdOrAuth($id);

        $userData = ArrayHelper::removeEqualAttributes($userData, $user);

        if (isset($userData['firstname'])) {
            $userData['name'] = $userData['firstname'];
        }

        if (empty($userData)) {
            return [];
        }

        if ($this->request->hasFile('avatar')) {
            $userData['avatar'] = $this->request->file('avatar');
        }

        User::getValidatorUpdate($userData)->validate();

        if (isset($userData['password'])) {
            $userData['password'] = bcrypt($userData['password']);
        }

        $this->updatePushSession($userData, $user);
        $this->repository->update($userData, $user->id);
        $user = $this->repository->find($user->id);

        if (isset($userData['avatar'])) {
            $userData['avatar'] = $user->avatar;
            $userData['avatarSmall'] = $user->avatarSmall;
        }

        return $userData;
    }

    public function updateRoles(Request $request) {
        $userData = $request->all();

        if ($this->user->hasRole('admin')) {
            if (!empty($userData['roles'])) {
                $newRoles = $userData['roles'];
                $userRoles = $user->roles->pluck('id')->all();
                $delete = array_diff($userRoles, $newRoles);
                if (is_array($userRoles) && count($userRoles) > 0) {
                    $newRoles = array_diff($newRoles, $userRoles);
                }
                $user->roles()->attach($newRoles);
                $user->roles()->detach($delete);
            } else {
                $user->roles()->detach();
            }
        }
    }

    private function updatePushSession(&$userData, $user) {
        if (array_key_exists('push_id', $userData)) {
            $token = $user->token()->id;

            $pushSession = PushSession::where('access_token', '=', $token)
                    ->first();

            //$pushSession = $user->pushSession->keyBy('id')->get($token);

            if (empty($pushSession)) {
                PushSession::create([
                    'access_token' => $token
                    , 'push_id' => $userData['push_id']
                    , 'user_id' => $user->id
                ]);
            } else {
                if ($pushSession->push_id === $userData['push_id']) {
                    unset($userData['push_id']);
                    return;
                }
                if (empty($userData['push_id'])) {
                    $userData['push_id'] = null;
                }
                $pushSession->update(['push_id' => $userData['push_id']]);
            }
        }
    }

    private static function getByIdOrAuth($id) {
        if (empty($id)) {
            $user = Auth::user();
        } else {
            $user = User::findOrFail($id);
        }
        return $user;
    }

}
