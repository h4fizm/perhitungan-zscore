<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Models\Pasien;
use App\Models\Location;
use App\Models\BBlaki;
use Carbon\Carbon;

class PasienController extends Controller
{
    public function index($id)
    {
        $pasien = Pasien::findOrFail($id);
        $jenis_kelamin = ['laki-laki', 'perempuan'];
        $faskes = Location::pluck('name_location', 'id')->toArray();

        // Retrieve all measurements for the selected patient based on 'nik'
        $measurements = Pasien::where('nik', $pasien->nik)->orderBy('tanggal_pengukuran', 'desc')->get();

        $umurOptions = BBlaki::orderBy('umur')->get();

        return view('menu.detail-pengukuran', compact('pasien', 'jenis_kelamin', 'faskes', 'measurements', 'umurOptions', 'id'));
    }

    public function tambah($id)
    {
        $pasien = Pasien::findOrFail($id);
        $faskes = Location::pluck('name_location', 'id')->toArray();
        $jenis_kelamin = ['laki-laki', 'perempuan'];
        $umurOptions = BBlaki::pluck('umur', 'umur')->toArray(); // Ambil nilai umur dari tabel BBlaki

        // Hitung umur dalam bulan
        $tanggal_lahir = Carbon::parse($pasien->tanggal_lahir);
        $umur = $tanggal_lahir->diffInMonths(Carbon::now());

        return view('menu.tambah-pengukuran', compact('pasien', 'jenis_kelamin', 'faskes', 'id', 'umurOptions', 'umur'));
    }

    public function simpan(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'jenis_kelamin' => 'required',
            'umur' => 'required|numeric',
            'berat_badan' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
        ]);

        // Simpan data pasien ke database
        Pasien::create([
            'nik' => Pasien::findOrFail($id)->nik,
            'nama' => Pasien::findOrFail($id)->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => Pasien::findOrFail($id)->tanggal_lahir,
            'umur' => $request->umur,
            'alamat' => Pasien::findOrFail($id)->alamat,
            'id_location' => Pasien::findOrFail($id)->location->id,
            'tanggal_pengukuran' => now(), // Menggunakan nilai saat ini dari created_at
            'berat_badan' => $request->berat_badan,
            'tinggi_badan' => $request->tinggi_badan,
            'status_gizi' => 'normal', // Nilai default untuk status gizi
            'status_tinggi' => 'normal', // Nilai default untuk status tinggi
        ]);

        return redirect()->route('tambah-pengukuran', $id)->with('success', 'Data pasien berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pengukuran = Pasien::findOrFail($id);

        return view('menu.edit-pengukuran', compact('pengukuran', 'id'));
    }
    public function update(Request $request, $id)
    {
        // Validasi data yang dikirimkan dari form
        $request->validate([
            'berat_badan' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
        ]);

        try {
            // Cari data pengukuran berdasarkan ID
            $pengukuran = Pasien::findOrFail($id);

            // Update data pengukuran dengan data yang dikirimkan dari form
            $pengukuran->update([
                'berat_badan' => $request->berat_badan,
                'tinggi_badan' => $request->tinggi_badan,
            ]);

            // Redirect kembali ke halaman edit dengan pesan sukses
            return redirect()->back()->with('success', 'Data pengukuran berhasil diperbarui');
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Gagal memperbarui data pengukuran');
        }
    }

    public function delete($id): RedirectResponse
    {
        try {
            // Temukan pengukuran berdasarkan ID
            $pengukuran = Pasien::findOrFail($id);

            // Ambil NIK pasien terkait sebelum penghapusan
            $pasien_nik = $pengukuran->nik;

            // Hapus pengukuran
            $pengukuran->delete();

            // Temukan pasien dengan NIK yang sama dan nilai tinggi serta berat badan 0
            $pasien_zero = Pasien::where('nik', $pasien_nik)
                ->where('tinggi_badan', 0)
                ->where('berat_badan', 0)
                ->first();

            // Redirect ke halaman detail-pengukuran dengan ID pasien jika ditemukan
            if ($pasien_zero) {
                return redirect()->route('detail-pengukuran', ['id' => $pasien_zero->id])
                    ->with('success', 'Data pengukuran berhasil dihapus.');
            } else {
                // Jika tidak ditemukan pasien dengan tinggi dan berat badan 0, arahkan kembali ke halaman detail pasien
                $pasien = Pasien::where('nik', $pasien_nik)->first();
                return redirect()->route('detail-pengukuran', ['id' => $pasien->id])
                    ->with('success', 'Data pengukuran berhasil dihapus.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data pengukuran.');
        }
    }
}
