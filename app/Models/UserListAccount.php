<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserListAccount extends Model
{
    protected $fillable = [
        'steamid', 'avatar', 'name', 'community_banned', 'number_of_vac_bans', 'number_of_game_bans', 'last_ban_date',
    ];

    public function lists()
    {
        return $this->belongsToMany('App\Models\UserList');
    }

    public function getLastBanTime()
    {
        return Carbon::parse($this->last_ban_date);
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function getAvatarMedium()
    {
        return rtrim($this->avatar, '.jpg') . '_medium.jpg';
    }

    public function getAvatarFull()
    {
        return rtrim($this->avatar, '.jpg') . '_full.jpg';
    }
}
