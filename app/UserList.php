<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserList extends Model
{
    protected $fillable = [
        'name', 'privacy',
    ];

    static $listPrivacyTypes = [
        'public' => 'Public',
        'unlisted' => 'Unlisted',
        'private' => 'Private',
    ];

    protected static function boot() {
        parent::boot();

        static::deleting(function($list) {
            $list->accounts()->detach();
            $list->subscribers()->delete();
        });
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function accounts() {
        return $this->belongsToMany('App\UserListAccount')
            ->withTimestamps();
    }

    public function subscribers() {
        return $this->hasMany('App\UserListSubscription');
    }

    public function getBannedAccounts() {
        return $this->accounts->filter(function($account) {
            return $account->number_of_vac_bans > 0 || $account->number_of_game_bans > 0;
        });
    }

    public function addToList($steamIds) {
        $steamApiClient = new SteamApiClient;

        foreach (array_chunk($steamIds, 100) as $steamIds) {
            $summaries = $steamApiClient->getPlayerSummaries(implode(',', $steamIds));
            $bans = $steamApiClient->getPlayerBans(implode(',', $steamIds));

            foreach ($steamIds as $steamId) {
                $summary = array_filter($summaries, function ($e) use ($steamId) {
                    return $e['steamid'] == $steamId;
                });

                if (empty($summary)) {
                    continue;
                }

                $ban = array_filter($bans, function ($e) use ($steamId) {
                    return $e['SteamId'] == $steamId;
                });

                if (empty($ban)) {
                    continue;
                }

                $summary = array_shift($summary);
                $ban = array_shift($ban);

                $account = UserListAccount::firstOrNew(['steamid' => $steamId]);
                $account->steamid = $steamId;
                $account->avatar = $summary['avatar'];
                $account->name = $summary['personaname'];
                $account->number_of_vac_bans = $ban['NumberOfVACBans'];
                $account->number_of_game_bans = $ban['NumberOfGameBans'];
                $account->last_ban_date = Carbon::now()->subDays($ban['DaysSinceLastBan']);
                $account->save();

                $this->accounts()->syncWithoutDetaching([$account->id]);
            }
        }
    }
}
