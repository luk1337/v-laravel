<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserList extends Model
{
    protected $fillable = [
        'name', 'privacy',
    ];

    static $listPrivacyTypes = [
        "public" => "Public",
        "unlisted" => "Unlisted",
        "private" => "Private",
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function accounts() {
        return $this->belongsToMany('App\UserListAccount');
    }

    public function subscribers() {
        return $this->hasMany('App\UserListSubscription');
    }
}