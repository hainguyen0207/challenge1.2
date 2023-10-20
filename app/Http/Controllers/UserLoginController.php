<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function postLogin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('users.index');
        }

        return redirect()->back()->with('error', 'Tên đăng nhập hoặc mật khẩu không đúng !');
    }

    public function signout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

}