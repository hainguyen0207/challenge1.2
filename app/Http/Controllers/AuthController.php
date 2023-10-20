<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getFormLogin()
    {
        return view('auth.login');
    }

    public function submitLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        if (
            Auth::attempt([
                'email' => $username,
                'password' => $password
            ])
        ) {
            $user = User::where('email', $username)->first();
            Auth::login($user);
            //return 
        }
    }
}