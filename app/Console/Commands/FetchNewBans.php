<?php

namespace App\Console\Commands;

use App\Models\UserList;
use App\Models\UserListAccount;
use App\Notifications\NewBansNotification;
use App\SteamApiClient;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Console\Command;

class FetchNewBans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'v:fetch-new-bans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches new vac/game bans and sends out emails.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $updatedLists = [];

        UserListAccount::chunk(100, function ($accounts) use (&$steamApiClient, &$updatedLists) {
            $steamApiClient = new SteamApiClient;
            $summaries = null;
            $bans = null;

            while (true) {
                try {
                    $summaries = $steamApiClient->getPlayerSummaries($accounts->implode('steamid', ','));
                    echo "getPlayerSummaries() succeeded!\n";
                    break;
                } catch (ClientException $e) {
                    if ($e->getResponse()->getStatusCode() == 429) {
                        echo "getPlayerSummaries() hit 429, retrying after 5s...\n";
                        sleep(5);
                    } else {
                        throw $e;
                    }
                }
            }

            while (true) {
                try {
                    $bans = $steamApiClient->getPlayerBans($accounts->implode('steamid', ','));
                    echo "getPlayerBans() succeeded!\n";
                    break;
                } catch (ClientException $e) {
                    if ($e->getResponse()->getStatusCode() == 429) {
                        echo "getPlayerBans() hit 429, retrying after 5s...\n";
                        sleep(5);
                    } else {
                        throw $e;
                    }
                }
            }

            foreach ($accounts as $account) {
                $summary = array_filter($summaries, function ($e) use ($account) {
                    return array_key_exists('steamid', $e) && (int)$e['steamid'] === $account->steamid;
                });

                if (empty($summary)) {
                    continue;
                }

                $ban = array_filter($bans, function ($e) use ($account) {
                    return array_key_exists('SteamId', $e) && (int)$e['SteamId'] === $account->steamid;
                });

                if (empty($ban)) {
                    continue;
                }

                $summary = array_shift($summary);
                $ban = array_shift($ban);

                $account = UserListAccount::where('steamid', $account->steamid)->firstOrFail();

                if ($account->community_banned !== (int)$ban['CommunityBanned'] ||
                    $account->number_of_vac_bans !== $ban['NumberOfVACBans'] ||
                    $account->number_of_game_bans !== $ban['NumberOfGameBans']) {
                    $account->community_banned = $ban['CommunityBanned'];
                    $account->number_of_vac_bans = $ban['NumberOfVACBans'];
                    $account->number_of_game_bans = $ban['NumberOfGameBans'];
                    $account->last_ban_date = Carbon::now()->subDays($ban['DaysSinceLastBan']);

                    foreach ($account->lists()->get() as $list) {
                        if (!array_key_exists($list->id, $updatedLists)) {
                            $updatedLists[$list->id] = [$account->id];
                        } else {
                            array_push($updatedLists[$list->id], $account->id);
                        }
                    }
                }

                $account->avatar = $summary['avatar'];
                $account->name = $summary['personaname'];
                $account->save();
            }
        });

        foreach ($updatedLists as $key => $value) {
            $list = UserList::findOrFail($key);
            $accounts = UserListAccount::findMany($value);

            $list->user()->first()->notify(new NewBansNotification($list, $accounts));

            if ($list->privacy !== 'private') {
                foreach ($list->subscribers()->get() as $subscriber) {
                    $subscriber->user()->first()->notify(new NewBansNotification($list, $accounts));
                }
            }
        }
    }
}
