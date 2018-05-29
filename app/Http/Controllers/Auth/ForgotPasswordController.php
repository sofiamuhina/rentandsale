<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\ApiResponse;

class ForgotPasswordController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Password Reset Controller
      |--------------------------------------------------------------------------
      |
      | This controller is responsible for handling password reset emails and
      | includes a trait which assists in sending these notifications from
      | your application to your users. Feel free to explore this trait.
      |
     */

use SendsPasswordResetEmails {
        sendResetLinkEmail as public sRLE;
        //sendResetLinkResponse as protected sRLR;
        //sendResetLinkFailedResponse as sRLFR;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    public function forgotPasswordForm() {
        return view('auth/passwords/email');
    }

    public function sendResetLinkEmail(Request $request) {
        if (empty($request->email) && $this->isApi($request)) {
            return ApiResponse::error('Email param is not set');
        }
        
        //$this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker($request)->sendResetLink(
            $request->only('email'), $this->isApi($request)
        );

        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }
    
    protected function sendResetLinkResponse(Request $request, $response) {
        if ($this->isApi($request)) {
            return ['message' => 'The reset code was sent to specified email'];
        } else {
            return redirect()->route('password.reset', ['email' => $request->email]);
        }       
    }

    protected function sendResetLinkFailedResponse(Request $request, $response) {
        if ($this->isApi($request)) {
            return ApiResponse::error('The reset code was not sent');
        }        
        //parent::sendResetLinkFailedResponse($request, $response);
    }
    
    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker(Request $request)
    {
        if ($this->isApi($request)) {
            return Password::broker('api');
        }
        return Password::broker();
    }

    private function isApi(Request $request) {
        return $request->is('api/*');
    }
    
    

}
