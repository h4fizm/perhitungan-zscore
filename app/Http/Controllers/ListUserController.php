<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Location; // Tambahkan ini

class ListUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('menu.manajemen-role', compact('users'));
    }

    public function create()
    {
        $locations = Location::all(); // Ambil semua data puskesmas
        return view('menu.tambah-role', compact('locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:5|confirmed',
            'role' => 'required|string|in:Admin,Guest,Operator',
            'id_location' => 'required_if:role,Operator|exists:locations,id', // Validasi hanya jika role adalah Operator
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->role = $request->input('role');
        $user->id_location = $request->input('id_location'); // Tambahkan ini
        $user->save();

        return redirect()->route('list-user.create')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $locations = Location::all(); // Ambil semua data puskesmas
        return view('menu.edit-role', compact('user', 'locations'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id),
                'max:255'
            ],
            'password' => 'nullable|string|min:5|confirmed',
            'role' => 'required|string|in:Admin,Guest,Operator',
            'id_location' => 'required_if:role,Operator|exists:locations,id', // Validasi hanya jika role adalah Operator
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->role = $request->input('role');
        $user->id_location = $request->input('id_location'); // Tambahkan ini
        $user->save();

        return redirect()->route('list-user.edit', $user->id)->with('success', 'User berhasil diperbarui.');
    }


    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->back()->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus user.');
        }
    }
}
