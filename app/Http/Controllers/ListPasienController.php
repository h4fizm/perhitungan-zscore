<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Pasien;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;


class ListPasienController extends Controller
{
    public function lokasipasien($id)
    {
        // Mendapatkan data lokasi
        $location = Location::findOrFail($id);

        // Subquery untuk mendapatkan data terbaru dari setiap nik
        $subquery = DB::table('pasien as p1')
            ->select('p1.nik', DB::raw('MAX(p1.created_at) as max_created_at'))
            ->groupBy('p1.nik');

        // Join subquery dengan tabel pasien untuk mendapatkan data terbaru per nik dan filter berdasarkan lokasi
        $pasien = Pasien::joinSub($subquery, 'latest', function ($join) {
            $join->on('pasien.nik', '=', 'latest.nik')
                ->on('pasien.created_at', '=', 'latest.max_created_at');
        })
            ->where('pasien.id_location', $id)
            ->orderByDesc('latest.max_created_at') // Urutkan berdasarkan created_at terbaru
            ->paginate(5); // Menambahkan pagination dengan 5 data per halaman

        // Mengambil status gizi dari pengukuran terbaru secara global
        $latest_measurement = Pasien::latest('created_at')->first();
        $latest_status = $latest_measurement ? $latest_measurement->status_gizi : 'Belum ada pengukuran';

        return view("menu.manajemen-pasien-lokasi", compact('pasien', 'latest_status', 'location'));
    }
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'Operator') {
            $userLocationId = $user->id_location;

            // Subquery to get the latest data for each nik filtered by location
            $subquery = DB::table('pasien as p1')
                ->select('p1.nik', DB::raw('MAX(p1.created_at) as max_created_at'))
                ->where('p1.id_location', $userLocationId)
                ->groupBy('p1.nik');

            // Join subquery with pasien table to get the latest data per nik filtered by location
            $pasien = Pasien::joinSub($subquery, 'latest', function ($join) {
                $join->on('pasien.nik', '=', 'latest.nik')
                    ->on('pasien.created_at', '=', 'latest.max_created_at');
            })
                ->where('pasien.id_location', $userLocationId)
                ->orderByDesc('latest.max_created_at') // Order by the latest created_at
                ->paginate(5); // Add pagination with 5 items per page
        } else {
            // Subquery to get the latest data for each nik without location filtering
            $subquery = DB::table('pasien as p1')
                ->select('p1.nik', DB::raw('MAX(p1.created_at) as max_created_at'))
                ->groupBy('p1.nik');

            // Join subquery with pasien table to get the latest data per nik without location filtering
            $pasien = Pasien::joinSub($subquery, 'latest', function ($join) {
                $join->on('pasien.nik', '=', 'latest.nik')
                    ->on('pasien.created_at', '=', 'latest.max_created_at');
            })
                ->orderByDesc('latest.max_created_at') // Order by the latest created_at
                ->paginate(5); // Add pagination with 5 items per page
        }

        return view("menu.manajemen-pasien", compact('pasien'));
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
            'nik' => 'required|unique:pasien|digits:16',
            'no_rekam_medis' => 'required|unique:pasien',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'faskes' => 'required|exists:locations,id', // Memastikan faskes yang dipilih valid
        ]);

        // Hitung umur dari tanggal lahir yang diberikan
        $tanggal_lahir = Carbon::parse($request->tanggal_lahir);
        $umur = $tanggal_lahir->diffInMonths(Carbon::now());

        // Simpan data pasien ke database
        $pasien = Pasien::create([
            'nik' => $request->nik,
            'no_rekam_medis' => $request->no_rekam_medis,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tempat_lahir' => $request->tempat_lahir,
            'nama_ortu' => $request->nama_ortu,
            'email_ortu' => $request->email_ortu,
            'umur' => $umur,
            'alamat' => $request->alamat,
            'id_location' => $request->faskes,
            'tanggal_pengukuran' => now(), // Menggunakan nilai saat ini dari created_at
            'berat_badan' => 0,
            'tinggi_badan' => 0,
            'status_gizi' => 'normal', // Nilai default untuk status gizi
            'status_tinggi' => 'normal', // Nilai default untuk status tinggi
        ]);

        // return redirect()->route('tambah-pasien')->with('success', 'Data pasien berhasil ditambahkan');
        return redirect()->route('tambah-pengukuran', ['id' => $pasien->id])->with('success', 'Data pasien baru berhasil ditambahkan, silahkan tambahkan data pengukuran pertama.');
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
        $pasien = Pasien::findOrFail($id);

        // Validasi data berdasarkan perubahan nik
        if ($pasien->nik === $request->nik) {
            $request->validate([
                'nik' => 'required|digits:16',
                'no_rekam_medis' => 'required|unique:pasien,no_rekam_medis,' . $id,
                'nama' => 'required',
                'jenis_kelamin' => 'required',
                'tanggal_lahir' => 'required|date',
                'alamat' => 'required',
                'faskes' => 'required',
            ]);
        } else {
            $request->validate([
                'nik' => 'required|unique:pasien,nik,' . $id . '|digits:16',
                'no_rekam_medis' => 'required|unique:pasien,no_rekam_medis,' . $id,
                'nama' => 'required',
                'jenis_kelamin' => 'required',
                'tanggal_lahir' => 'required|date',
                'alamat' => 'required',
                'faskes' => 'required',
            ]);
        }

        // Hitung umur dari tanggal lahir yang diberikan
        $tanggal_lahir = Carbon::parse($request->tanggal_lahir);
        $umur = $tanggal_lahir->diffInMonths(Carbon::now());

        // Logika update data pasien
        if ($pasien->nik === $request->nik) {
            // Jika NIK tidak berubah, update semua entri dengan NIK yang sama
            Pasien::where('nik', $pasien->nik)->update([
                'no_rekam_medis' => $request->no_rekam_medis,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'nama_ortu' => $request->nama_ortu,
                'email_ortu' => $request->email_ortu,
                'umur' => $umur,
                'alamat' => $request->alamat,
                'id_location' => $request->faskes,
            ]);
        } else {
            // Jika NIK berubah, update semua entri dengan NIK yang sama (NIK lama)
            Pasien::where('nik', $pasien->nik)->update([
                'nik' => $request->nik,
                'no_rekam_medis' => $request->no_rekam_medis,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'nama_ortu' => $request->nama_ortu,
                'email_ortu' => $request->email_ortu,
                'umur' => $umur,
                'alamat' => $request->alamat,
                'id_location' => $request->faskes,
            ]);
        }

        return Redirect::route('edit-pasien', $pasien->id)->with('success', 'Data pasien berhasil diperbarui');
    }



    public function destroy($id)
    {
        try {
            // Temukan pasien berdasarkan ID
            $pasien = Pasien::findOrFail($id);

            // Ambil nik dari pasien yang akan dihapus
            $nik = $pasien->nik;

            // Hapus semua pasien dengan nik yang sama
            Pasien::where('nik', $nik)->delete();

            return redirect()->back()->with('success', 'Pasien berhasil dihapus beserta seluruh data yang memiliki NIK yang sama.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus pasien.');
        }
    }



}