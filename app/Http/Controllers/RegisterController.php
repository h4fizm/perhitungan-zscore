<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'agreement' => 'required',
        ], [
            'password.confirmed' => 'The password confirmation does not match.',
            'agreement.required' => 'You must agree to the terms and conditions.',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                // Jangan set remember_token di sini
            ]);

            // Setelah membuat user, Anda dapat mengisi remember_token secara otomatis
            $user->update([
                'remember_token' => Str::random(10),
            ]);

            return back()->with('success', 'Your account has been registered successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
