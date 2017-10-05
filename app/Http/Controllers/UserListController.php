<?php

namespace App\Http\Controllers;

use App\UserList;
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
        $list = UserList::where('user_id', Auth::User()->id)->where('uuid', $uuid)->firstOrFail();
        $list->delete();

        return redirect('/list/my');
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

        $list = UserList::where('user_id', Auth::User()->id)->where('uuid', $uuid)->firstOrFail();
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

    public function getPublic()
    {
        return view('list/public')
            ->with('lists', UserList::where('privacy', 'public')->get());
    }

    public function getShow($uuid)
    {
        return view('list/show')
            ->with('list', UserList::where(function ($query) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::User()->id)
                        ->orWhere('privacy', "public")
                        ->orWhere('privacy', "unlisted");
                } else {
                    $query->where('privacy', "public")
                        ->orWhere('privacy', "unlisted");
                }
            })->where('uuid', $uuid)->firstOrFail());
    }
}