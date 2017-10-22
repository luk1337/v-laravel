<?php

namespace App\Http\Controllers;

use App\UserListAccount;

class LatestBansController extends Controller
{
    function getIndex() {
        $accounts = UserListAccount::where(function ($query) {
            $query->where('number_of_vac_bans', '>', 0)
                ->orWhere('number_of_game_bans', '>', 0);
        })->orderBy('last_ban_updated_at', 'desc')->paginate(150);

        return view('latest-bans')
            ->with('accounts', $accounts);
    }
}
