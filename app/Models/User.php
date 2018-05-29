<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use App\Entities\AuthenticifiableModel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword;
use Laravel\Passport\HasApiTokens;
use Illuminate\Http\UploadedFile;
use App\Utils\FileHelper;

class User extends AuthenticifiableModel {

    use Notifiable,
        HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'salary'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];
    protected static $validatorCreateParams = [
        'name' => 'required|string|between:1,40',
        'email' => 'required|string|email|max:70|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'phone' => 'nullable|integer|digits_between:7,15|unique:users',
    ];
    protected static $validatorUpdateParams = [
        'name' => 'sometimes|required|string|max:40',
        'email' => 'sometimes|required|string|email|max:70|unique:users',
        'password' => 'sometimes|required|string|min:6|confirmed',
        'phone' => 'nullable|integer|digits_between:7,15|unique:users',
    ];

  
    
    public function sendPasswordResetNotification($token, $isApi = false) {
        $this->notify(new class($token, $this->email, $isApi) extends ResetPassword {

            protected $email;
            protected $isApi;

            public function __construct($token, $email, $isApi) {
                parent::__construct($token);
                $this->email = $email;
                $this->isApi = $isApi;
            }

            /**
             * Build the mail representation of the notification.
             *
             * @param  mixed  $notifiable
             * @return \Illuminate\Notifications\Messages\MailMessage
             */
            public function toMail($notifiable) {
                $routeParams = ['token' => $this->token];
                if ($this->email) {
                    $routeParams['email'] = $this->email;
                }
                $message = (new class() extends MailMessage {
                            
                        });

                $message->line('You have received this message '
                        . 'as response on your password reset request');
                if ($this->isApi) {
                    $message->line("This code can be used to reset the password "
                            . "in application: " . $routeParams['token']);
                } else {
                    $message->action('Reset password', config('app.url')
                            . route('password.reset', $routeParams, false));
                    //->from(config("mail.from.address"), config("mail.from.name"))
                }
                $message->line('If you have not requested password reset, '
                        . 'then no further actionn required');
                $message->subject('Password reset');

                return $message;
            }
        });
    }

}
