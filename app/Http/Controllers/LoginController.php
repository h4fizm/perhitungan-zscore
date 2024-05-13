<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('user.login');
    }

    public function register()
    {
        return view('user.register');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->route('dashboard');
        } else {
            // Authentication failed...
            return redirect()->route('login')->withErrors(['error' => 'Invalid email or password']);
        }
    }
}
