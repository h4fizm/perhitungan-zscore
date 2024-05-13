<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Pengukuran;
use App\Models\Location;
use App\Models\BBlaki;

class PasienController extends Controller
{
    public function index($id)
    {
        $pasien = Pasien::findOrFail($id);
        $jenis_kelamin = ['laki-laki', 'perempuan'];
        $faskes = Location::pluck('name_location', 'id')->toArray();
        $pengukuran = Pengukuran::where('id_pasien', $pasien->id)->orderBy('tanggal_pengukuran', 'desc')->get();
        $umurOptions = BBlaki::orderBy('umur')->get();

        return view('menu.detail-pengukuran', compact('pasien', 'jenis_kelamin', 'faskes', 'pengukuran', 'umurOptions', 'id'));
    }

    public function tambah($id)
    {
        $pasien = Pasien::findOrFail($id);
        $faskes = Location::pluck('name_location', 'id')->toArray();
        $jenis_kelamin = ['laki-laki', 'perempuan'];
        $pengukuran = Pengukuran::where('id_pasien', $pasien->id)->orderBy('tanggal_pengukuran', 'desc')->get();
        $umurOptions = BBlaki::pluck('umur', 'umur')->toArray(); // Ambil nilai umur dari tabel BBlaki

        return view('menu.tambah-pengukuran', compact('pasien', 'jenis_kelamin', 'faskes', 'id', 'umurOptions', 'pengukuran'));
    }

    public function simpan(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'jenis_kelamin' => 'required',
            'umur' => 'required',
            'berat_badan' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
        ]);

        // Simpan data pengukuran pasien ke dalam database
        Pengukuran::create([
            'id_pasien' => $id, // Mengambil id_pasien dari parameter URL
            'tanggal_pengukuran' => now(), // Gunakan waktu saat ini sebagai tanggal pengukuran
            'umur' => $request->umur, // Simpan umur dalam bulan
            'berat_badan' => $request->berat_badan,
            'tinggi_badan' => $request->tinggi_badan,
        ]);

        // Redirect kembali ke halaman tambah-pengukuran dengan memberikan pesan sukses
        return redirect()->route('tambah-pengukuran', ['id' => $id])->with('success', 'Data pengukuran berhasil disimpan.');
    }
    public function edit($id)
    {
        // Fetch the Pengukuran record for editing
        $pengukuran = Pengukuran::findOrFail($id);
        $jenis_kelamin = ['laki-laki', 'perempuan'];
        $umurOptions = BBlaki::pluck('umur', 'umur')->toArray(); // tambahkan variabel $umurOptions
    
        // Pass the necessary data to the view
        return view('menu.edit-pengukuran', compact('pengukuran', 'jenis_kelamin', 'umurOptions')); // tambahkan $umurOptions ke dalam compact
    }
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'umur' => 'required',
            'berat_badan' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
        ]);

        try {
            $pengukuran = Pengukuran::findOrFail($id);
            $pengukuran->umur = $request->umur;
            $pengukuran->berat_badan = $request->berat_badan;
            $pengukuran->tinggi_badan = $request->tinggi_badan;

            // Simpan perubahan
            $pengukuran->save();

            return redirect()->route('edit-pengukuran', ['id' => $pengukuran->id])->with('success', 'Data pengukuran berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('edit-pengukuran', ['id' => $id])->with('error', 'Gagal memperbarui data pengukuran.');
        }
    }

    public function destroy($id)
    {
        try {
            $pengukuran = Pengukuran::findOrFail($id);
            $pengukuran->delete();

            return redirect()->back()->with('success', 'Data pengukuran berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data pengukuran.');
        }
    }

}
