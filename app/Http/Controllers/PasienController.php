<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Models\Pasien;
use App\Models\Location;
use App\Models\BBlaki;
use App\Models\BBperempuan;
use App\Models\BbtBlaki;
use App\Models\Bbtbperempuan;
use App\Models\TBlaki;
use App\Models\TBperempuan;
use Carbon\Carbon;

class PasienController extends Controller
{
    public function index($id)
    {
        $pasien = Pasien::findOrFail($id);
        $jenis_kelamin = ['laki-laki', 'perempuan'];
        $faskes = Location::pluck('name_location', 'id')->toArray();

        $measurements = Pasien::where('nik', $pasien->nik)->orderBy('tanggal_pengukuran', 'desc')->get();

        $umurOptions = BBlaki::orderBy('umur')->get();

        // Retrieve the location information for the patient
        $location = Location::findOrFail($pasien->id_location);

        $medianValue = null;

        $bbn3sdData = [];
        $bbp3sdData = [];
        $bbn2sdData = [];
        $bbp2sdData = [];
        $bbn1sdData = [];
        $bbp1sdData = [];
        $labels = [];

        if ($pasien->jenis_kelamin == 'laki-laki') {
            $dataBBPasien = BBlaki::orderBy('UMUR')->get();
            $tbData = TBlaki::orderBy('UMUR')->get();
            $bbtbData = BbtBlaki::orderBy('TB')->get();
            $Weight = $pasien->berat_badan;
            $height = $pasien->tinggi_badan;
            // dd($height);exit();

            if ($height > 0 && $Weight > 0) {
                // $roundedHeight = 0;
                $roundedHeight = round($height, 0, PHP_ROUND_HALF_UP);

                $medianRecord = BbtBlaki::where('TB', $roundedHeight)->first();
                if ($medianRecord) {
                    $medianValue = $medianRecord->MEDIAN;
                }
                $rentangTerdekat = $Weight - $medianValue;
                // dd($medianValue);exit();

                if ($rentangTerdekat >= 0 && $rentangTerdekat <= 2) {
                    $zScoreFromP1SD = BbtBlaki::where('TB', $pasien->umur)->pluck('P1SD')->first();

                    $NilaiRentangTerdekat = $zScoreFromP1SD;

                } else if ($rentangTerdekat > 2 && $rentangTerdekat <= 3) {
                    $zScoreFromP2SD = BbtBlaki::where('TB', $pasien->umur)->pluck('P2SD')->first();

                    $NilaiRentangTerdekat = $zScoreFromP2SD;
                } else if ($rentangTerdekat >= 3) {
                    $zScoreFromP3SD = BbtBlaki::where('TB', $pasien->umur)->pluck('P3SD')->first();

                    $NilaiRentangTerdekat = $zScoreFromP3SD;
                } else if ($rentangTerdekat < 0 && $rentangTerdekat >= -2) {
                    $zScoreFromN1SD = BbtBlaki::where('TB', $pasien->umur)->pluck('N1SD')->first();

                    $NilaiRentangTerdekat = $zScoreFromN1SD;
                } else if ($rentangTerdekat < -2 && $rentangTerdekat >= -3) {
                    $zScoreFromN2SD = BbtBlaki::where('TB', $pasien->umur)->pluck('N2SD')->first();

                    $NilaiRentangTerdekat = $zScoreFromN2SD;
                } else if ($rentangTerdekat < -3) {
                    $zScoreFromN3SD = BbtBlaki::where('TB', $pasien->umur)->pluck('N3SD')->first();

                    $NilaiRentangTerdekat = $zScoreFromN3SD;
                }
                // dd($NilaiRentangTerdekat);exit();
                $ZScoreWH = ($Weight - $medianValue) / ($medianValue - $NilaiRentangTerdekat);

                $medianRecordHeight = TBlaki::where('UMUR', $pasien->umur)->first();
                // dd($medianRecordHeight);exit();
                if ($medianRecordHeight) {
                    $medianValueHeight = $medianRecordHeight->MEDIAN;
                }
                // dd($medianValue);exit();
                $rentangTerdekatHeigt = $height - $medianValueHeight;
                if ($rentangTerdekatHeigt > 0 && $rentangTerdekatHeigt <= 2) {
                    $zScoreFromP1SD = TBlaki::where('UMUR', $pasien->umur)->pluck('P1SD')->first();

                    $NilaiRentangTerdekatHeight = $zScoreFromP1SD;

                } else if ($rentangTerdekatHeigt > 2 && $rentangTerdekatHeigt <= 3) {
                    $zScoreFromP2SD = TBlaki::where('UMUR', $pasien->umur)->pluck('P2SD')->first();

                    $NilaiRentangTerdekatHeight = $zScoreFromP2SD;
                } else if ($rentangTerdekatHeigt >= 3) {
                    $zScoreFromP3SD = TBlaki::where('UMUR', $pasien->umur)->pluck('P3SD')->first();

                    $NilaiRentangTerdekatHeight = $zScoreFromP3SD;
                } else if ($rentangTerdekatHeigt < 0 && $rentangTerdekatHeigt >= -2) {
                    $zScoreFromN1SD = TBlaki::where('UMUR', $pasien->umur)->pluck('N1SD')->first();

                    $NilaiRentangTerdekatHeight = $zScoreFromN1SD;
                } else if ($rentangTerdekatHeigt < -2 && $rentangTerdekatHeigt >= -3) {
                    $zScoreFromN2SD = TBlaki::where('UMUR', $pasien->umur)->pluck('N2SD')->first();

                    $NilaiRentangTerdekatHeight = $zScoreFromN2SD;
                } else if ($rentangTerdekatHeigt < -3) {
                    $zScoreFromN3SD = TBlaki::where('UMUR', $pasien->umur)->pluck('N3SD')->first();

                    $NilaiRentangTerdekatHeight = $zScoreFromN3SD;
                }
                $ZScoreHeight = ($height - $medianValueHeight) / ($medianValueHeight - $NilaiRentangTerdekatHeight);

                $medianRecordWeight = BBlaki::where('UMUR', $pasien->umur)->first();

                if ($medianRecordWeight) {
                    $medianWeightValue = $medianRecordWeight->MEDIAN;
                }
                $rentangTerdekatWeight = $Weight - $medianWeightValue;
                if ($rentangTerdekatWeight > 0 && $rentangTerdekatWeight <= 2) {
                    $zScoreFromP1SD = BBlaki::where('UMUR', $pasien->umur)->pluck('P1SD')->first();

                    $NilaiRentangTerdekatWeight = $zScoreFromP1SD;

                } else if ($rentangTerdekatWeight > 2 && $rentangTerdekatWeight <= 3) {
                    $zScoreFromP2SD = BBlaki::where('UMUR', $pasien->umur)->pluck('P2SD')->first();

                    $NilaiRentangTerdekatWeight = $zScoreFromP2SD;
                } else if ($rentangTerdekatWeight >= 3) {
                    $zScoreFromP3SD = BBlaki::where('UMUR', $pasien->umur)->pluck('P3SD')->first();

                    $NilaiRentangTerdekatWeight = $zScoreFromP3SD;
                } else if ($rentangTerdekatWeight < 0 && $rentangTerdekatWeight >= -2) {
                    $zScoreFromN1SD = BBlaki::where('UMUR', $pasien->umur)->pluck('N1SD')->first();

                    $NilaiRentangTerdekatWeight = $zScoreFromN1SD;
                } else if ($rentangTerdekatWeight < -2 && $rentangTerdekatWeight >= -3) {
                    $zScoreFromN2SD = BBlaki::where('UMUR', $pasien->umur)->pluck('N2SD')->first();

                    $NilaiRentangTerdekatWeight = $zScoreFromN2SD;
                } else if ($rentangTerdekatWeight < -3) {
                    $zScoreFromN3SD = BBlaki::where('UMUR', $pasien->umur)->pluck('N3SD')->first();

                    $NilaiRentangTerdekatWeight = $zScoreFromN3SD;
                }
                $ZScoreWeight = ($Weight - $medianWeightValue) / ($medianWeightValue - $NilaiRentangTerdekatWeight);
                // dd($ZScoreWeight);exit();
            } else {
                $ZScoreWeight = null; // Set ZScore to null if Weight is not greater than 0
                $ZScoreWH = null; // Set ZScore to null if Weight is not greater than 0
                $ZScoreHeight = null; // Set ZScore to null if Weight is not greater than 0
            }
        } else {
            $medianRecord = BBperempuan::where('UMUR', $pasien->umur)->first();
            $dataBBPasien = BBperempuan::orderBy('UMUR')->get();
            $tbData = TBperempuan::orderBy('UMUR')->get();
            $bbtbData = Bbtbperempuan::orderBy('TB')->get();
            $medianHeight = TBperempuan::where('UMUR', $pasien->umur)->first();
            // Check if the record exists and retrieve the Median value
            if ($medianRecord) {
                $medianValue = $medianRecord->MEDIAN;
            }
            $Weight = $pasien->berat_badan;

            $height = $pasien->tinggi_badan;

            // dd($height);exit(); 
            if ($height > 0) {
                if ($medianHeight) {
                    $medianValueHeight = $medianHeight->MEDIAN;
                }
                $rentangTerdekatHeight = $height - $medianValueHeight;

                if ($rentangTerdekatHeight > 0 && $rentangTerdekatHeight <= 1) {
                    $zScoreFromP1SD = TBperempuan::where('UMUR', $pasien->umur)->pluck('P1SD')->first();

                    $NilaiRentangTerdekatHeight = $zScoreFromP1SD;

                } else if ($rentangTerdekatHeight > 1 && $rentangTerdekatHeight <= 2) {
                    $zScoreFromP2SD = TBperempuan::where('UMUR', $pasien->umur)->pluck('P2SD')->first();

                    $NilaiRentangTerdekatHeight = $zScoreFromP2SD;
                } else if ($rentangTerdekatHeight >= 2) {
                    $zScoreFromP3SD = TBperempuan::where('UMUR', $pasien->umur)->pluck('P3SD')->first();

                    $NilaiRentangTerdekatHeight = $zScoreFromP3SD;
                } else if ($rentangTerdekatHeight < 0 && $rentangTerdekatHeight >= -1) {
                    $zScoreFromN1SD = TBperempuan::where('UMUR', $pasien->umur)->pluck('N1SD')->first();

                    $NilaiRentangTerdekatHeight = $zScoreFromN1SD;
                } else if ($rentangTerdekatHeight < 1 && $rentangTerdekatHeight >= -2) {
                    $zScoreFromN2SD = TBperempuan::where('UMUR', $pasien->umur)->pluck('N2SD')->first();

                    $NilaiRentangTerdekatHeight = $zScoreFromN2SD;
                } else if ($rentangTerdekatHeight < 2) {
                    $zScoreFromN3SD = TBperempuan::where('UMUR', $pasien->umur)->pluck('N3SD')->first();

                    $NilaiRentangTerdekatHeight = $zScoreFromN3SD;
                }

                $ZScoreHeight = ($height - $medianValueHeight) / ($medianValueHeight - $NilaiRentangTerdekatHeight);
            }

            if ($Weight > 0) {
                $rentangTerdekat = $Weight - $medianValue;
                if ($rentangTerdekat > 0 && $rentangTerdekat <= 1) {
                    // Jika rentang terdekat <= 1, ambil nilai P1SD dari tabel bb-laki-laki
                    $zScoreFromP1SD = BBperempuan::where('UMUR', $pasien->umur)->pluck('P1SD')->first();

                    // Gunakan nilai P1SD sebagai Z-Score
                    $NilaiRentangTerdekat = $zScoreFromP1SD;

                } else if ($rentangTerdekat > 1 && $rentangTerdekat <= 2) {
                    $zScoreFromP2SD = BBperempuan::where('UMUR', $pasien->umur)->pluck('P2SD')->first();

                    // Gunakan nilai P2SD sebagai Z-Score
                    $NilaiRentangTerdekat = $zScoreFromP2SD;
                } else if ($rentangTerdekat >= 2) {
                    $zScoreFromP3SD = BBperempuan::where('UMUR', $pasien->umur)->pluck('P3SD')->first();

                    // Gunakan nilai P3SD sebagai Z-Score
                    $NilaiRentangTerdekat = $zScoreFromP3SD;
                } else if ($rentangTerdekat < 0 && $rentangTerdekat >= -1) {
                    $zScoreFromN1SD = BBperempuan::where('UMUR', $pasien->umur)->pluck('N1SD')->first();

                    // Gunakan nilai N1SD sebagai Z-Score
                    $NilaiRentangTerdekat = $zScoreFromN1SD;
                } else if ($rentangTerdekat < 1 && $rentangTerdekat >= -2) {
                    $zScoreFromN2SD = BBperempuan::where('UMUR', $pasien->umur)->pluck('N2SD')->first();

                    // Gunakan nilai N2SD sebagai Z-Score
                    $NilaiRentangTerdekat = $zScoreFromN2SD;
                } else if ($rentangTerdekat < 2) {
                    $zScoreFromN3SD = BBperempuan::where('UMUR', $pasien->umur)->pluck('N3SD')->first();

                    // Gunakan nilai N3SD sebagai Z-Score
                    $NilaiRentangTerdekat = $zScoreFromN3SD;
                }
                $ZScore = ($Weight - $medianValue) / ($medianValue - $NilaiRentangTerdekat);
            }
            if ($height > 0 && $Weight > 0) {
                $medianRecord = Bbtbperempuan::where('TB', $pasien->umur)->first();

                if ($medianRecord) {
                    $medianValue = $medianRecord->MEDIAN;
                }
                $rentangTerdekat = $Weight - $medianValue;
                if ($rentangTerdekat > 0 && $rentangTerdekat <= 2) {
                    $zScoreFromP1SD = Bbtbperempuan::where('TB', $pasien->umur)->pluck('P1SD')->first();

                    $NilaiRentangTerdekat = $zScoreFromP1SD;

                } else if ($rentangTerdekat > 2 && $rentangTerdekat <= 3) {
                    $zScoreFromP2SD = Bbtbperempuan::where('TB', $pasien->umur)->pluck('P2SD')->first();

                    $NilaiRentangTerdekat = $zScoreFromP2SD;
                } else if ($rentangTerdekat >= 3) {
                    $zScoreFromP3SD = Bbtbperempuan::where('TB', $pasien->umur)->pluck('P3SD')->first();

                    $NilaiRentangTerdekat = $zScoreFromP3SD;
                } else if ($rentangTerdekat < 0 && $rentangTerdekat >= -2) {
                    $zScoreFromN1SD = Bbtbperempuan::where('TB', $pasien->umur)->pluck('N1SD')->first();

                    $NilaiRentangTerdekat = $zScoreFromN1SD;
                } else if ($rentangTerdekat < -2 && $rentangTerdekat >= -3) {
                    $zScoreFromN2SD = Bbtbperempuan::where('TB', $pasien->umur)->pluck('N2SD')->first();

                    $NilaiRentangTerdekat = $zScoreFromN2SD;
                } else if ($rentangTerdekat < -3) {
                    $zScoreFromN3SD = Bbtbperempuan::where('TB', $pasien->umur)->pluck('N3SD')->first();

                    $NilaiRentangTerdekat = $zScoreFromN3SD;
                }
                $ZScore = ($Weight - $medianValue) / ($medianValue - $NilaiRentangTerdekat);
            }
            // dd($ZScore);exit();
            else {
                $ZScore = null; // Set ZScore to null if Weight is not greater than 0
            }
        }
        foreach ($dataBBPasien as $record) {
            $bblabels[] = $record->UMUR;
            $bbp3sdData[] = $record->P3SD;
            $bbp2sdData[] = $record->P2SD;
            $bbp1sdData[] = $record->P1SD;
            $bbn1sdData[] = $record->N1SD;
            $bbn2sdData[] = $record->N2SD;
            $bbn3sdData[] = $record->N3SD;
        }

        // Second chart data (Height to Age)
        $heightToAgeLabels = [];
        $n3sdHeightData = [];
        $p3sdHeightData = [];
        $n2sdHeightData = [];
        $p2sdHeightData = [];
        $n1sdHeightData = [];
        $p1sdHeightData = [];


        foreach ($tbData as $record) {
            $heightToAgeLabels[] = $record->UMUR;
            $n3sdHeightData[] = $record->N3SD;
            $p3sdHeightData[] = $record->P3SD;
            $n2sdHeightData[] = $record->N2SD;
            $p2sdHeightData[] = $record->P2SD;
            $n1sdHeightData[] = $record->N1SD;
            $p1sdHeightData[] = $record->P1SD;
        }

        //third data chart
        foreach ($bbtbData as $record) {
            $weightToHeightLabels[] = $record->TB;
            $n3sdWeightData[] = $record->N3SD;
            $p3sdWeightData[] = $record->P3SD;
            $n2sdWeightData[] = $record->N2SD;
            $p2sdWeightData[] = $record->P2SD;
            $n1sdWeightData[] = $record->N1SD;
            $p1sdWeightData[] = $record->P1SD;
        }
        $tbValues = BbtBlaki::orderBy('TB', 'asc')->pluck('TB');


        // dd($ZScore);exit();

        return view('menu.detail-pengukuran', compact('location', 'pasien', 'jenis_kelamin', 'faskes', 'measurements', 'umurOptions', 'id', 'medianValue', 'ZScoreWeight', 'ZScoreHeight', 'ZScoreWH', 'bbn3sdData', 'n3sdHeightData', 'bbn2sdData', 'n2sdHeightData', 'bbn1sdData', 'n1sdHeightData', 'bbp1sdData', 'p1sdHeightData', 'bbp2sdData', 'p2sdHeightData', 'bbp3sdData', 'p3sdHeightData', 'bblabels', 'heightToAgeLabels', 'n3sdWeightData', 'p3sdWeightData', 'n2sdWeightData', 'p2sdWeightData', 'n1sdWeightData', 'p1sdWeightData', 'weightToHeightLabels', 'tbValues', 'Weight', 'height'));
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

        return redirect()->route('list-pasien')->with('success', 'Data pasien berhasil ditambahkan');
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
                return redirect()->route('list-pasien')
                    ->with('success', 'Data pengukuran berhasil dihapus.');
            } else {
                // Jika tidak ditemukan pasien dengan tinggi dan berat badan 0, arahkan kembali ke halaman detail pasien
                $pasien = Pasien::where('nik', $pasien_nik)->first();
                return redirect()->route('list-pasien')
                    ->with('success', 'Data pengukuran berhasil dihapus.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data pengukuran.');
        }
    }
}
