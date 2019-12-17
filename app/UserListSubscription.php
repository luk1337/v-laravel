<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserListSubscription extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_list_id', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function userList()
    {
        return $this->belongsTo('App\UserList');
    }
}
