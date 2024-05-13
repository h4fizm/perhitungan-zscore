<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Location;
use App\Models\Pengukuran;

class ListPasienController extends Controller
{

    public function index()
    {
        $pasien = Pasien::latest()->get(); // Ambil semua data pasien
        $pasien->each(function ($item) { // Loop melalui setiap pasien
            $latestPengukuran = $item->pengukuran()->latest('tanggal_pengukuran')->first(); // Ambil pengukuran terbaru untuk pasien ini melalui relasi
            $item->latest_status = $latestPengukuran ? $latestPengukuran->status_gizi : ''; // Tambahkan status terbaru ke dalam objek pasien
        });
        $latest_measurement = Pengukuran::latest('tanggal_pengukuran')->first(); // Ambil pengukuran terbaru secara global
        $latest_status = $latest_measurement ? $latest_measurement->status_gizi : 'Belum ada pengukuran'; // Ambil status dari pengukuran terbaru atau beri keterangan jika belum ada pengukuran

        return view("menu.manajemen-pasien", compact('pasien', 'latest_status'));
    }


    public function tambah()
    {
        $jenis_kelamin = ['laki-laki', 'perempuan'];
        $faskes = Location::pluck('name_location', 'id')->toArray();

        return view("menu.tambah-pasien", compact('jenis_kelamin', 'faskes'));
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:pasien|digits:16', // Memastikan NIK memiliki tepat 16 digit
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'faskes' => 'required',
        ]);

        Pasien::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'id_location' => $request->faskes, // Pastikan ini sesuai dengan name field dalam form
        ]);

        return redirect()->route('tambah-pasien')->with('success', 'Data pasien berhasil ditambahkan');
    }
    public function edit($id)
    {
        $pasien = Pasien::findOrFail($id);
        $jenis_kelamin = ['laki-laki', 'perempuan'];
        $faskes = Location::pluck('name_location', 'id')->toArray();
        return view('menu.edit-pasien', compact('pasien', 'jenis_kelamin', 'faskes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required|unique:pasien,nik,' . $id . '|digits:16', // Memastikan NIK memiliki tepat 16 digit
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'faskes' => 'required',
        ]);

        $pasien = Pasien::findOrFail($id);
        $pasien->update([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'id_location' => $request->faskes,
        ]);

        return Redirect::route('edit-pasien', $pasien->id)->with('success', 'Data pasien berhasil diperbarui');
    }


    public function destroy($id)
    {
        try {
            // Temukan user berdasarkan ID
            $user = Pasien::findOrFail($id);

            // Hapus user
            $user->delete();

            return redirect()->back()->with('success', 'Pasien berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus pasien.');
        }
    }


}