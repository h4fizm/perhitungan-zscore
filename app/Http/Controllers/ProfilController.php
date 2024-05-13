<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;

class ProfilController extends Controller
{
    public function index()
    {
        return view('menu.profil');
    }

    public function edit()
    {
        // Ambil data pengguna yang sedang login
        $user = Auth::user();

        return view('menu.edit-profil', compact('user'));
    }

    public function update(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore(Auth::id()), // Memastikan email unik, tetapi mengabaikan pengguna yang sedang disunting
            ],
            'password' => 'nullable|string|min:5|confirmed',
        ]);

        // Memperbarui data pengguna
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

}


