<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Modules\Users\Entities\Users;

class HomeController extends Controller
{
    public function login_screen()
    {
        return view("auth.login");
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {

            if (auth()->user()->is_active == 0) {

                Session::flush();
                Auth::logout();

                return redirect()->back()->withErrors([
                    'message' => 'Your account is disabled.',
                ]);
            }

            return redirect()->route("dashboard")->withSuccess('Signed In Successfully');
        }


        return redirect()->back()->withErrors([
            'message' => 'Email and password is not correct.',
        ]);
    }

    public function signout()
    {

        if (Auth::check()) {

            Session::flush();
            Auth::logout();

            return Redirect()->route("login.screen");
        }
    }

    public function dashboard()
    {
        return view("admin.dashboard");
    }
}
