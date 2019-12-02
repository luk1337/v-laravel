<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ApiKeyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    function getIndex()
    {
        return view('api-key')
            ->with('api_key', Auth::user()->api_key);
    }

    function postReset(Request $request)
    {
        $user = Auth::user();
        $user->api_key = null;
        $user->save();

        return redirect('/api-key');
    }

    function postRegen(Request $request)
    {
        $user = Auth::user();
        $user->api_key = Str::random(64);
        $user->save();

        return redirect('/api-key');
    }
}
