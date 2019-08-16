<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Model;
    use Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id', 'remember_token', 'created_at', 'updated_at'
    ];


    use Traits\Serial;
    public static $s_prefix = 'IQ';
    public static $s_start = 24300000;
    public static $s_end = 728999999;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function sendPasswordResetNotification($token)
    {
        dispatch(new \Majazeh\Dashboard\Jobs\SendEmail('emails.recovery', ['email' => $this->email, 'token' => $token, 'title' => _d('change.password.verify.code')]));
    }
}
