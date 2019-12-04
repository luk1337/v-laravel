<?php

namespace App\Http\Controllers;

use App\SteamApiClient;
use App\UserList;
use App\UserListSubscription;
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
            ],
        ]);
    }

    public function getAdd($uuid)
    {
        return view('list/add')
            ->with('list', Auth::user()->lists()->where('uuid', $uuid)->firstOrFail());
    }

    public function postAdd(Request $request, $uuid)
    {
        $this->validate($request, [
            'steamids' => ['required'],
        ]);

        $steamApiClient = new SteamApiClient;
        $list = Auth::user()->lists()->where('uuid', $uuid)->firstOrFail();
        $steamIds = [];

        foreach (preg_split('/\r\n|[\r\n]/', $request->steamids) as $sid) {
            $steamId = $steamApiClient->convertToSteamID64($sid);

            if (!empty($steamId)) {
                array_push($steamIds, $steamId);
            }
        }

        $list->addToList($steamIds);

        return redirect()->route('list/show', ['uuid' => $uuid]);
    }

    public function getCreate()
    {
        return view('list/create');
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:64'],
            'privacy' => ['required', 'in:' . implode(',', array_keys(UserList::$listPrivacyTypes))],
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
            ->with('list', Auth::user()->lists()->where('uuid', $uuid)->firstOrFail());
    }

    public function postDelete(Request $request, $uuid)
    {
        $list = Auth::user()->lists()->where('uuid', $uuid)->firstOrFail();
        $list->delete();

        return redirect('/list/my');
    }

    public function getDeleteAccount($uuid, $steamid)
    {
        $list = Auth::user()->lists()->where('uuid', $uuid)->firstOrFail();
        $account = $list->accounts()->where('steamid', $steamid)->firstOrFail();

        return view('list/delete_account')
            ->with('list', $list)
            ->with('account', $account);
    }

    public function postDeleteAccount(Request $request, $uuid, $steamid)
    {
        $list = Auth::user()->lists()->where('uuid', $uuid)->firstOrFail();
        $list->accounts()->detach($list->accounts()->where('steamid', $steamid)->firstOrFail());

        return redirect()->route('list/show', ['uuid' => $uuid]);
    }

    public function getEdit($uuid)
    {
        return view('list/edit')
            ->with('list', Auth::user()->lists()->where('uuid', $uuid)->firstOrFail());
    }

    public function postEdit(Request $request, $uuid)
    {
        $this->validate($request, [
            'name' => ['required', 'max:64'],
            'privacy' => ['required', 'in:' . implode(',', array_keys(UserList::$listPrivacyTypes))]
        ]);

        $list = Auth::user()->lists()->where('uuid', $uuid)->firstOrFail();
        $list->name = $request->name;
        $list->privacy = $request->privacy;
        $list->saveOrFail();

        return redirect('/list/my');
    }

    public function getMy()
    {
        return view('list/my')
            ->with('lists', Auth::user()->lists()->get());
    }

    public function getMySubscriptions()
    {
        $lists = UserList::where('user_id', '!=', Auth::id())
            ->whereIn('id', Auth::user()->subscriptions()->get(['user_list_id']))
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
        $list = UserList::where('uuid', $uuid)
            ->where(function ($query) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::id())
                        ->orWhereIn('privacy', ['public', 'unlisted']);
                } else {
                    $query->whereIn('privacy', ['public', 'unlisted']);
                }
            })
            ->firstOrFail();
        $accounts = $list->accounts()->orderBy('id', 'desc')->paginate(150);

        return view('list/show')
            ->with('list', $list)
            ->with('accounts', $accounts);
    }

    public function getSubscribe($uuid)
    {
        $list = UserList::where('uuid', $uuid)
            ->where('user_id', '!=', Auth::id())
            ->whereIn('privacy', ['public', 'unlisted'])
            ->firstOrFail();

        return view('list/subscribe')
            ->with('list', $list);
    }

    public function postSubscribe(Request $request, $uuid)
    {
        $list = UserList::where('uuid', $uuid)
            ->where('user_id', '!=', Auth::id())
            ->whereIn('privacy', ['public', 'unlisted'])
            ->firstOrFail();

        $subscription = UserListSubscription::firstOrNew(['user_list_id' => $list->id, 'user_id' => Auth::id()]);
        $subscription->save();

        return redirect('/list/public');
    }

    public function getUnsubscribe($uuid)
    {
        $list = UserList::where('uuid', $uuid)
            ->where('user_id', '!=', Auth::id())
            ->whereIn('privacy', ['public', 'unlisted'])
            ->firstOrFail();

        return view('list/unsubscribe')
            ->with('list', $list);
    }

    public function postUnsubscribe(Request $request, $uuid)
    {
        $list = UserList::where('uuid', $uuid)
            ->where('user_id', '!=', Auth::id())
            ->whereIn('privacy', ['public', 'unlisted'])
            ->firstOrFail();

        $subscription = UserListSubscription::firstOrNew(['user_list_id' => $list->id, 'user_id' => Auth::id()]);
        $subscription->delete();

        return redirect('/list/public');
    }
}
