<?php

use App\SteamApiClient;
use App\User;
use App\UserList;
use App\UserListSubscription;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/list/add', function (Request $request) {
    if (is_null($request->api_key)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing API key.',
        ]);
    }

    $user = User::where('api_key', $request->api_key)
        ->get()
        ->first();

    if (is_null($user)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing API key.',
        ]);
    }

    if (!is_array($request->steamids)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or missing `steamids` parameter.',
        ]);
    }

    $list = UserList::where('user_id', $user->id)
        ->where('uuid', $request->uuid)
        ->first();

    if (is_null($list)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or missing `uuid` parameter.',
        ]);
    }

    $steamApiClient = new SteamApiClient;
    $steamIds = [];

    foreach ($request->steamids as $sid) {
        $steamId = $steamApiClient->convertToSteamID64($sid);

        if (!empty($steamId)) {
            array_push($steamIds, $steamId);
        }
    }

    $list->addToList($steamIds);

    return response()->json([
        'status' => 'success',
    ]);
});

Route::post('/list/create', function (Request $request) {
    if (is_null($request->api_key)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing API key.',
        ]);
    }

    $user = User::where('api_key', $request->api_key)
        ->get()
        ->first();

    if (is_null($user)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing API key.',
        ]);
    }

    if (empty($request->name) || strlen($request->name) > 32) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or missing `name` parameter.',
        ]);
    }

    if (empty($request->privacy) || !in_array($request->privacy, array_keys(App\UserList::$listPrivacyTypes))) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or missing `privacy` parameter.',
        ]);
    }

    $list = new UserList;
    $list->uuid = Uuid::generate()->string;
    $list->name = $request->name;
    $list->privacy = $request->privacy;
    $list->user()->associate($user);
    $list->saveOrFail();

    return response()->json([
        'status' => 'success'
    ]);
});

Route::post('/list/delete', function (Request $request) {
    if (is_null($request->api_key)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing API key.',
        ]);
    }

    $user = User::where('api_key', $request->api_key)
        ->get()
        ->first();

    if (is_null($user)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing API key.',
        ]);
    }

    $list = UserList::where('user_id', $user->id)
        ->where('uuid', $request->uuid)
        ->first();

    if (is_null($list)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or missing `uuid` parameter.',
        ]);
    }

    $list->subscribers()->delete();
    $list->delete();

    return response()->json([
        'status' => 'success',
    ]);
});

Route::post('/list/delete/account', function (Request $request) {
    if (is_null($request->api_key)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing API key.',
        ]);
    }

    $user = User::where('api_key', $request->api_key)
        ->get()
        ->first();

    if (is_null($user)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing API key.',
        ]);
    }

    if (empty($request->steamid)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or missing `steamid` parameter.',
        ]);
    }

    $list = UserList::where('user_id', $user->id)
        ->where('uuid', $request->uuid)
        ->first();

    if (is_null($list)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or missing `uuid` parameter.',
        ]);
    }

    $list->accounts()
        ->detach($list->accounts()
            ->where('steamid', $request->steamid)
            ->first());

    return response()->json([
        'status' => 'success',
    ]);
});

Route::post('/list/edit', function (Request $request) {
    if (is_null($request->api_key)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing API key.',
        ]);
    }

    $user = User::where('api_key', $request->api_key)
        ->get()
        ->first();

    if (is_null($user)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing API key.',
        ]);
    }

    if (empty($request->name) || strlen($request->name) > 32) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or missing `name` parameter.',
        ]);
    }

    if (empty($request->privacy) || !in_array($request->privacy, array_keys(App\UserList::$listPrivacyTypes))) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or missing `privacy` parameter.',
        ]);
    }

    $list = UserList::where('user_id', $user->id)
        ->where('uuid', $request->uuid)
        ->first();

    if (is_null($list)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or missing `uuid` parameter.',
        ]);
    }

    $list->name = $request->name;
    $list->privacy = $request->privacy;
    $list->save();

    return response()->json([
        'status' => 'success'
    ]);
});

Route::post('/list/my', function (Request $request) {
    if (is_null($request->api_key)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing API key.',
        ]);
    }

    $user = User::where('api_key', $request->api_key)
        ->get()
        ->first();

    if (is_null($user)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing API key.',
        ]);
    }

    $lists = UserList::where('user_id', $user->id)
        ->get(['uuid', 'name', 'privacy', 'created_at']);

    return response()->json([
        'status' => 'success',
        'lists' => $lists,
    ]);
});

Route::post('/list/my/subscriptions', function (Request $request) {
    if (is_null($request->api_key)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing API key.',
        ]);
    }

    $user = User::where('api_key', $request->api_key)
        ->get()
        ->first();

    if (is_null($user)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing API key.',
        ]);
    }

    $lists = UserList::where('user_id', '!=', $user->id)
        ->whereIn('id', $user->subscriptions()->get(['user_list_id']))
        ->whereIn('privacy', ['public', 'unlisted'])
        ->get();

    return response()->json([
        'status' => 'success',
        'lists' => $lists,
    ]);
});

Route::post('/list/public', function (Request $request) {
    if (is_null($request->api_key)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing API key.',
        ]);
    }

    $user = User::where('api_key', $request->api_key)
        ->get()
        ->first();

    if (is_null($user)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing API key.',
        ]);
    }

    $lists = UserList::where('privacy', 'public')
        ->get();

    return response()->json([
        'status' => 'success',
        'lists' => $lists,
    ]);
});

Route::post('/list/subscribe', function (Request $request) {
    if (is_null($request->api_key)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing API key.',
        ]);
    }

    $user = User::where('api_key', $request->api_key)
        ->get()
        ->first();

    if (is_null($user)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing API key.',
        ]);
    }

    $list = UserList::where('user_id', '!=', $user->id)
        ->where('uuid', $request->uuid)
        ->whereIn('privacy', ['public', 'unlisted'])->first();

    if (is_null($list)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or missing `uuid` parameter.',
        ]);
    }

    $subscription = UserListSubscription::firstOrNew(['user_list_id' => $list->id, 'user_id' => $user->id]);
    $subscription->save();

    return response()->json([
        'status' => 'success',
    ]);
});

Route::post('/list/unsubscribe', function (Request $request) {
    if (is_null($request->api_key)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing API key.',
        ]);
    }

    $user = User::where('api_key', $request->api_key)
        ->get()
        ->first();

    if (is_null($user)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing API key.',
        ]);
    }

    $list = UserList::where('user_id', '!=', $user->id)
        ->where('uuid', $request->uuid)
        ->whereIn('privacy', ['public', 'unlisted'])->first();

    if (is_null($list)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or missing `uuid` parameter.',
        ]);
    }

    $subscription = UserListSubscription::firstOrNew(['user_list_id' => $list->id, 'user_id' => $user->id]);
    $subscription->delete();

    return response()->json([
        'status' => 'success',
    ]);
});

Route::post('/list/show', function (Request $request) {
    if (is_null($request->api_key)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing API key.',
        ]);
    }

    $user = User::where('api_key', $request->api_key)
        ->get()
        ->first();

    if (is_null($user)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Missing API key.',
        ]);
    }

    $list = UserList::where('user_id', $user->id)
        ->where('uuid', $request->uuid)
        ->whereIn('privacy', ['public', 'unlisted'])
        ->first();

    if (is_null($list)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or missing `uuid` parameter.',
        ]);
    }

    $accounts = $list->accounts()
        ->orderBy('user_list_account_id', 'desc')
        ->get(['steamid', 'avatar', 'name', 'number_of_vac_bans', 'number_of_game_bans', 'last_ban_date', 'user_list_accounts.created_at']);

    return response()->json([
        'status' => 'success',
        'accounts' => $accounts,
    ]);
});