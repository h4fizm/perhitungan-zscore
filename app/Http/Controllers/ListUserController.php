<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User; // Tambahkan ini untuk menggunakan model User

class ListUserController extends Controller
{
    public function index()
    {
        // Ambil semua data pengguna dari database
        $users = User::all();

        // Kirim data pengguna ke tampilan
        return view('menu.manajemen-role', compact('users'));
    }

    // FUNGSI TAMBAH USER
    public function create()
    {
        return view('menu.tambah-role');
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:5|confirmed',
            'role' => 'required|string|in:admin,guest', // Tambahkan validasi untuk role
        ]);

        // Simpan data pengguna baru ke dalam database
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->role = $request->input('role');
        $user->save();

        // Redirect kembali ke halaman list user dengan pesan sukses
        // Di dalam method store() ListUserController
        return redirect()->route('list-user.create')->with('success', 'User berhasil ditambahkan.');
    }

    // FUNGSI EDIT USER
    public function edit($id)
    {
        // Temukan user berdasarkan ID
        $user = User::findOrFail($id);

        // Kirim data user ke tampilan edit
        return view('menu.edit-role', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id),
                'max:255'
            ],
            'password' => 'nullable|string|min:5|confirmed',
            'role' => 'required|string|in:admin,guest', // Tambahkan validasi untuk role
        ]);

        // Temukan user berdasarkan ID
        $user = User::findOrFail($id);

        // Update data user
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->role = $request->input('role');
        $user->save();

        // Redirect kembali ke halaman edit profil dengan pesan sukses
        return redirect()->route('list-user.edit', $user->id)->with('success', 'User berhasil diperbarui.');
    }

    // FUNGSI DELETE USER

    public function destroy($id)
    {
        try {
            // Temukan user berdasarkan ID
            $user = User::findOrFail($id);

            // Hapus user
            $user->delete();

            return redirect()->back()->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus user.');
        }
    }


}
