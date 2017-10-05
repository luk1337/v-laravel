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
}