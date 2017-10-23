<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserListAccount extends Model
{
    protected $fillable = [
        'steamid', 'avatar', 'name', 'number_of_vac_bans', 'number_of_game_bans', 'last_ban_date',
    ];

    public function lists() {
        return $this->belongsToMany('App\UserList');
    }

    public function getLastBanTime() {
        return Carbon::parse($this->last_ban_date);
    }
}