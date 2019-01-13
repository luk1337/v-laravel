<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
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
        return view('auth.change-password');
    }

    function postIndex(Request $request)
    {
        Validator::extend('user_password', function ($attribute, $value, $parameters) {
            return Hash::check($value, Auth::user()->password);
        });

        $this->validate($request, [
            'current_password' => ['required', 'user_password'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/');
    }
}
