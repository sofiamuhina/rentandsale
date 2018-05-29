<?php

namespace App\Http\Controllers\Auth;

use App\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Validator;

class ApiLoginController {

    private static $apiClientId = 2;
    private static $apiClientSecret = 'aAfU8KFivrcTEXZBW1D0j933z9C4ELxnAwv7MH4d';
    private $appUrl;
    private $hostUrl;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        //$this->appUrl = $this->makeUrl($request);
        $this->appUrl = 'localhost';
        $this->hostUrl = $request->getHost();
        //$this->middleware('guest')->except('logout');
    }

    public function login(Request $request) {
        $this->validateLogin($request);

        /* if ($this->hasTooManyLoginAttempts($request)) {
          $this->fireLockoutEvent($request);

          return $this->sendLockoutResponse($request);
          } */

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        //$this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function attemptLogin(Request $request) {
        return Auth::guard('api')->attempt(
                        $this->credentials($request), $request->has('remember')
        );
    }
    
    public function getTokenBySession() {
        $user = Auth::user();
        if (empty($user)) {
            throw new AuthorizationException();
        }
        $token = $user->createToken('blabla');
        return $token;
    }

    /*public function oauthRedirect(Request $request) {
        $query = http_build_query([
            'client_id' => 'client-id',
            'redirect_uri' => 'http://example.com/callback',
            'response_type' => 'code',
            'scope' => '',
            'headers' => [
                    'Host' => $this->hostUrl
                ]
        ]);

        return redirect($this->appUrl . '/oauth/authorize?' . $query);
    }*/

    public function apiAuth(Request $request) {
        return $this->apiAuthArray($request->all());
    }

    public function apiAuthArray($request) {
        Validator::make($request, [
                    'email' => 'required|string|email|max:70',
                    'password' => 'required|string|min:6',
        ])->validate();
        $params = [
            'email' => $request['email'],
            'password' => $request['password'],
            'client_id' => self::$apiClientId,
            'client_secret' => self::$apiClientSecret,
            'scope' => '',
        ];
        return $this->getToken($params);
    }

    public function apiRefresh(Request $request) {
        $params = [
            'refresh_token' => $request->refresh_token,
            'client_id' => self::$apiClientId,
            'client_secret' => self::$apiClientSecret,
            'scope' => '',
        ];
        return $this->refreshToken($params);
    }

    public function getToken($params) {
        $http = new Client(['curl' => [CURLOPT_SSL_VERIFYPEER => false]]);
        try {
            $response = $http->post($this->appUrl . '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => $params['client_id'],
                    'client_secret' => $params['client_secret'],
                    'username' => $params['email'],
                    'password' => $params['password'],
                    'scope' => $params['scope'],
                ],
                'headers' => [
                    'Host' => $this->hostUrl
                ]
            ]);
        } catch (ClientException $e) {
            $res = $e->getResponse();
            return $res;
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
        $result = $response->getBody();

        //return json_decode((string) $response->getBody(), true);
        $response = Response::make($result);
        $response->header('Content-Type', 'application/json');

        return $response;
    }

    public function refreshToken($params) {
        $http = new Client;
        try {
            $response = $http->post($this->appUrl . '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $params['refresh_token'],
                    'client_id' => $params['client_id'],
                    'client_secret' => $params['client_secret'],
                    'scope' => $params['scope'],
                ],
                'headers' => [
                    'Host' => $this->hostUrl
                ]
            ]);
        } catch (ClientException $e) {
            $res = $e->getResponse();
            return $res;
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
        $result = $response->getBody();

        //return json_decode((string) $response->getBody(), true);
        $response = Response::make($result);
        $response->header('Content-Type', 'application/json');

        return $response;
    }

    public function apiDeauth(Request $request) {
        $user = Auth::user();

        if (isset($request->full) && $request->full == 1) {
            foreach ($user->tokens as $value) {
                $value->delete();
            }
        } else {
            $user->token()->delete();
        }

        return ['message' => 'Вы были успешно деавторизованы'];
    }

    /*private function makeUrl(Request $request) {
        $protocol = $request->isSecure() ? 'https' : 'http';
        $host = $request->getHost();
        return $protocol . '://' . $host;
    }*/

}
