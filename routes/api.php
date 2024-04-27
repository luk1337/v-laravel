<?php

use App\Http\Middleware\VerifyApiKey;
use App\Models\User;
use App\Models\UserList;
use App\Models\UserListAccount;
use App\Models\UserListSubscription;
use App\SteamApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Webpatser\Uuid\Uuid;

Route::post('/list/add', function (Request $request) {
    if (!is_array($request->steamids)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or missing `steamids` parameter.',
        ]);
    }

    $user = User::where('api_key', $request->api_key)->first();
    $list = $user->lists()->where('uuid', $request->uuid)->first();

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
})->middleware(VerifyApiKey::class);

Route::post('/list/create', function (Request $request) {
    if (empty($request->name) || strlen($request->name) > 64) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or missing `name` parameter.',
        ]);
    }

    if (empty($request->privacy) || !in_array($request->privacy, array_keys(UserList::$listPrivacyTypes))) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or missing `privacy` parameter.',
        ]);
    }

    $user = User::where('api_key', $request->api_key)->first();

    $list = new UserList;
    $list->uuid = Uuid::generate()->string;
    $list->name = $request->name;
    $list->privacy = $request->privacy;
    $list->user()->associate($user);
    $list->saveOrFail();

    return response()->json([
        'status' => 'success',
    ]);
})->middleware(VerifyApiKey::class);

Route::post('/list/delete', function (Request $request) {
    $user = User::where('api_key', $request->api_key)->first();
    $list = $user->lists()->where('uuid', $request->uuid)->first();

    if (is_null($list)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or missing `uuid` parameter.',
        ]);
    }

    $list->delete();

    return response()->json([
        'status' => 'success',
    ]);
})->middleware(VerifyApiKey::class);

Route::post('/list/delete/account', function (Request $request) {
    if (empty($request->steamid)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or missing `steamid` parameter.',
        ]);
    }

    $user = User::where('api_key', $request->api_key)->first();
    $list = $user->lists()->where('uuid', $request->uuid)->first();

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
})->middleware(VerifyApiKey::class);

Route::post('/list/edit', function (Request $request) {
    if (empty($request->name) || strlen($request->name) > 64) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or missing `name` parameter.',
        ]);
    }

    if (empty($request->privacy) || !in_array($request->privacy, array_keys(UserList::$listPrivacyTypes))) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or missing `privacy` parameter.',
        ]);
    }

    $user = User::where('api_key', $request->api_key)->first();
    $list = $user->lists()->where('uuid', $request->uuid)->first();

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
})->middleware(VerifyApiKey::class);

Route::post('/list/my', function (Request $request) {
    $user = User::where('api_key', $request->api_key)->first();
    $lists = $user->lists()->where('user_id', $user->id)
        ->get(['uuid', 'name', 'privacy', 'created_at']);

    return response()->json([
        'status' => 'success',
        'lists' => $lists,
    ]);
})->middleware(VerifyApiKey::class);

Route::post('/list/my/subscriptions', function (Request $request) {
    $user = User::where('api_key', $request->api_key)->first();
    $lists = UserList::where('user_id', '!=', $user->id)
        ->whereIn('id', $user->subscriptions()->get(['user_list_id']))
        ->whereIn('privacy', ['public', 'unlisted'])
        ->get();

    return response()->json([
        'status' => 'success',
        'lists' => $lists,
    ]);
})->middleware(VerifyApiKey::class);

Route::post('/list/public', function (Request $request) {
    $lists = UserList::where('privacy', 'public')->get();

    return response()->json([
        'status' => 'success',
        'lists' => $lists,
    ]);
})->middleware(VerifyApiKey::class);

Route::post('/list/subscribe', function (Request $request) {
    $user = User::where('api_key', $request->api_key)->first();
    $list = UserList::where('uuid', $request->uuid)
        ->where('user_id', '!=', $user->id)
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
})->middleware(VerifyApiKey::class);

Route::post('/list/unsubscribe', function (Request $request) {
    $user = User::where('api_key', $request->api_key)->first();
    $list = UserList::where('uuid', $request->uuid)
        ->where('user_id', '!=', $user->id)
        ->whereIn('privacy', ['public', 'unlisted'])->first();

    if (is_null($list)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or missing `uuid` parameter.',
        ]);
    }

    $subscription = $list->subscribers()->where('user_id', $user->id)->firstOrFail();
    $subscription->delete();

    return response()->json([
        'status' => 'success',
    ]);
})->middleware(VerifyApiKey::class);

Route::post('/list/show', function (Request $request) {
    $user = User::where('api_key', $request->api_key)->first();
    $list = UserList::where('uuid', $request->uuid)
        ->where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhereIn('privacy', ['public', 'unlisted']);
        })
        ->first();

    if (is_null($list)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or missing `uuid` parameter.',
        ]);
    }

    $accounts = $list->accounts()
        ->orderBy('pivot_id', 'desc')
        ->get(['steamid', 'avatar', 'name', 'community_banned', 'number_of_vac_bans', 'number_of_game_bans', 'last_ban_date', 'user_list_accounts.created_at']);

    return response()->json([
        'status' => 'success',
        'accounts' => $accounts,
    ]);
})->middleware(VerifyApiKey::class);

Route::post('/latest-bans', function (Request $request) {
    $accounts = UserListAccount::where(function ($query) {
        $query->where('number_of_vac_bans', '>', 0)
            ->orWhere('number_of_game_bans', '>', 0);
    })->orderBy('last_ban_date', 'desc')
        ->get(['steamid', 'name', 'community_banned', 'number_of_vac_bans', 'number_of_game_bans', 'last_ban_date']);

    return response()->json([
        'status' => 'success',
        'accounts' => $accounts,
    ]);
})->middleware(VerifyApiKey::class);
