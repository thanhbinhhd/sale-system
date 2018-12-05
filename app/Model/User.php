<?php

namespace App\Model;

use App\Notifications\ResetPasswordNotification;
use App\Notifications\UserVerifyMail;
use App\Scopes\StatusScope;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    const ACTIVE = 1;
    const BLOCK = 0;
    protected $fillable = [
        'name', 'email',
        'phone_number', 'address', 'avatar',
        'status', 'description', 'email_notify_enabled'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

//    public static function boot()
//    {
//        parent::boot();
//
//        static::addGlobalScope(new StatusScope());
//    }

    public function socialAccount()
    {
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new UserVerifyMail());
    }

}
