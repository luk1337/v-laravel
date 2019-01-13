<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected static function boot() {
        parent::boot();

        static::deleting(function ($user) {
            $user->lists()->delete();
            $user->subscriptions()->delete();
        });
    }

    public function lists() {
        return $this->hasMany('App\UserList');
    }

    public function subscriptions() {
        return $this->hasMany('App\UserListSubscription');
    }
}
