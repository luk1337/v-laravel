<?php

namespace App\Http\Controllers;

use App\SteamApiClient;
use App\UserList;
use App\UserListAccount;
use App\UserListSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class UserListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [
                'getIndex',
                'getPublic',
                'getShow',
            ]
        ]);
    }

    public function getAdd($uuid)
    {
        return view('list/add')
            ->with('list', UserList::where('user_id', Auth::User()->id)->where('uuid', $uuid)->firstOrFail());
    }

    public function postAdd(Request $request, $uuid)
    {
        $this->validate($request, [
            'steamids' => 'required',
        ]);

        $steamApiClient = new SteamApiClient;
        $list = UserList::where('user_id', Auth::User()->id)->where('uuid', $uuid)->firstOrFail();
        $steamIds = [];

        foreach (preg_split('/\r\n|[\r\n]/', $request->steamids) as $sid) {
            if (preg_match('/^\d{17}$/', $sid, $matches) || preg_match('/^http[s]?:\/\/steamcommunity.com\/profiles\/(\d{17})$/', $sid, $matches)) {
                array_push($steamIds, $matches[1]);
            } else if (preg_match('/^http[s]?:\/\/steamcommunity.com\/id\/(\w+)$/', $sid, $matches)) {
                $response = $steamApiClient->resolveVanityURL($matches[1]);

                if ($response['success'] == 1) {
                    array_push($steamIds, $response['steamid']);
                }
            }
        }

        foreach (array_chunk($steamIds, 100) as $steamIds) {
            $summaries = $steamApiClient->getPlayerSummaries(implode(',', $steamIds));
            $bans = $steamApiClient->getPlayerBans(implode(',', $steamIds));

            foreach ($steamIds as $steamId) {
                $summary = array_filter(
                    $summaries,
                    function ($e) use($steamId) {
                        return $e['steamid'] == $steamId;
                    }
                );

                if (empty($summary)) {
                    continue;
                }

                $ban = array_filter(
                    $bans,
                    function ($e) use($steamId) {
                        return $e['SteamId'] == $steamId;
                    }
                );

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

                $list->accounts()->syncWithoutDetaching([$account->id]);
            }
        }

        return redirect()->route('list/show', ['uuid' => $uuid]);
    }

    public function getCreate()
    {
        return view('list/create');
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:64',
            'privacy' => 'required|in:' . implode(",", array_keys(UserList::$listPrivacyTypes))
        ]);

        $list = new UserList;
        $list->uuid = Uuid::generate()->string;
        $list->name = $request->name;
        $list->privacy = $request->privacy;
        $list->user()->associate(Auth::user());
        $list->saveOrFail();

        return redirect('/list/my');
    }

    public function getDelete($uuid)
    {
        return view('list/delete')
            ->with('list', UserList::where('user_id', Auth::User()->id)->where('uuid', $uuid)->firstOrFail());
    }

    public function postDelete(Request $request, $uuid)
    {
        $list = UserList::where('user_id', Auth::User()->id)
            ->where('uuid', $uuid)->firstOrFail();
        $list->delete();

        return redirect('/list/my');
    }

    public function getDeleteAccount($uuid, $steamid)
    {
        $list = UserList::where('user_id', Auth::User()->id)
            ->where('uuid', $uuid)->firstOrFail();
        $account = $list->accounts()
            ->where('steamid', $steamid)->firstOrFail();

        return view('list/delete_account')
            ->with('list', $list)
            ->with('account', $account);
    }

    public function postDeleteAccount(Request $request, $uuid, $steamid)
    {
        $list = UserList::where('user_id', Auth::User()->id)
            ->where('uuid', $uuid)
            ->firstOrFail();
        $list->accounts()->detach($list->accounts()
            ->where('steamid', $steamid)
            ->firstOrFail());

        return redirect()->route('list/show', ['uuid' => $uuid]);
    }

    public function getEdit($uuid)
    {
        return view('list/edit')
            ->with('list', UserList::where('user_id', Auth::User()->id)->where('uuid', $uuid)->firstOrFail());
    }

    public function postEdit(Request $request, $uuid)
    {
        $this->validate($request, [
            'name' => 'required|max:64',
            'privacy' => 'required|in:' . implode(",", array_keys(UserList::$listPrivacyTypes))
        ]);

        $list = UserList::where('user_id', Auth::User()->id)
            ->where('uuid', $uuid)->firstOrFail();
        $list->name = $request->name;
        $list->privacy = $request->privacy;
        $list->saveOrFail();

        return redirect('/list/my');
    }

    public function getMy()
    {
        return view('list/my')
            ->with('lists', UserList::where('user_id', Auth::User()->id)->get());
    }

    public function getMySubscriptions()
    {
        $user = Auth::user();
        $lists = UserList::where('user_id', '!=', $user->id)
            ->whereIn('id', $user->subscriptions()->get(['user_list_id']))
            ->whereIn('privacy', ['public', 'unlisted'])
            ->get();

        return view('list/my_subscriptions')
            ->with('lists', $lists);
    }

    public function getPublic()
    {
        return view('list/public')
            ->with('lists', UserList::where('privacy', 'public')->get());
    }

    public function getShow($uuid)
    {
        $list = UserList::where(function ($query) {
            if (Auth::check()) {
                $query->where('user_id', Auth::User()->id)
                    ->whereIn('privacy', ['public', 'unlisted'], 'or');
            } else {
                $query->whereIn('privacy', ['public', 'unlisted'], 'or');
            }
        })->where('uuid', $uuid)->firstOrFail();
        $accounts = $list->accounts()
            ->orderBy('id', 'desc')
            ->paginate(150);

        return view('list/show')
            ->with('list', $list)
            ->with('accounts', $accounts);
    }

    public function getSubscribe($uuid)
    {
        $list = UserList::where('user_id', '!=', Auth::user()->id)
            ->where('uuid', $uuid)
            ->whereIn('privacy', ['public', 'unlisted'])->firstOrFail();

        return view('list/subscribe')
            ->with('list', $list);
    }

    public function postSubscribe(Request $request, $uuid)
    {
        $user = Auth::user();
        $list = UserList::where('user_id', '!=', $user->id)
            ->where('uuid', $uuid)
            ->whereIn('privacy', ['public', 'unlisted'])->firstOrFail();

        $subscription = UserListSubscription::firstOrNew(['user_list_id' => $list->id, 'user_id' => $user->id]);
        $subscription->save();

        return redirect('/list/public');
    }

    public function getUnsubscribe($uuid)
    {
        $list = UserList::where('user_id', '!=', Auth::user()->id)
            ->where('uuid', $uuid)
            ->whereIn('privacy', ['public', 'unlisted'])->firstOrFail();

        return view('list/unsubscribe')
            ->with('list', $list);
    }

    public function postUnsubscribe(Request $request, $uuid)
    {
        $user = Auth::user();
        $list = UserList::where('user_id', '!=', $user->id)
            ->where('uuid', $uuid)
            ->whereIn('privacy', ['public', 'unlisted'])
            ->firstOrFail();

        $subscription = UserListSubscription::firstOrNew(['user_list_id' => $list->id, 'user_id' => $user->id]);
        $subscription->delete();

        return redirect('/list/public');
    }
}