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

        $location = Location::findOrFail($pasien->id_location);

        $bbn3sdData = [];
        $bbp3sdData = [];
        $bbn2sdData = [];
        $bbp2sdData = [];
        $bbn1sdData = [];
        $bbp1sdData = [];
        $labels = [];

        $statusGizi = [];
        $statusTinggi = [];
        $statusWH = [];

        if ($pasien->jenis_kelamin == 'laki-laki') {
            $dataBBPasien = BBlaki::orderBy('UMUR')->get();
            $tbData = TBlaki::orderBy('UMUR')->get();
            $bbtbData = BbtBlaki::orderBy('TB')->get();
        } else {
            $dataBBPasien = BBperempuan::orderBy('UMUR')->get();
            $tbData = TBperempuan::orderBy('UMUR')->get();
            $bbtbData = Bbtbperempuan::orderBy('TB')->get();
        }

        foreach ($measurements as $measurement) {
            $umur = $measurement->umur;
            $berat_badan = $measurement->berat_badan;
            $tinggi_badan = $measurement->tinggi_badan;

            if ($tinggi_badan > 0 && $berat_badan > 0) {
                // Calculate Z Scores for Weight-for-Age, Height-for-Age, and Weight-for-Height
                $ZScoreWeight = $this->calculateZScoreWeight($pasien->jenis_kelamin, $umur, $berat_badan);
                $ZScoreHeight = $this->calculateZScoreHeight($pasien->jenis_kelamin, $umur, $tinggi_badan);
                $ZScoreWH = $this->calculateZScoreWH($pasien->jenis_kelamin, $tinggi_badan, $berat_badan);

                $statusGizi[] = $this->determineNutritionalStatus($ZScoreWeight);
                $statusTinggi[] = $this->determineHeightStatus($ZScoreHeight);
                $statusWH[] = $this->determineWeightHeightStatus($ZScoreWH);
            } else {
                $statusGizi[] = "data belum diisi";
                $statusTinggi[] = "data belum diisi";
                $statusWH[] = "data belum diisi";
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

        // Third data chart
        $weightToHeightLabels = [];
        $n3sdWeightData = [];
        $p3sdWeightData = [];
        $n2sdWeightData = [];
        $p2sdWeightData = [];
        $n1sdWeightData = [];
        $p1sdWeightData = [];

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

        return view('menu.detail-pengukuran', compact('location', 'pasien', 'jenis_kelamin', 'faskes', 'measurements', 'umurOptions', 'id', 'bbn3sdData', 'n3sdHeightData', 'bbn2sdData', 'n2sdHeightData', 'bbn1sdData', 'n1sdHeightData', 'bbp1sdData', 'p1sdHeightData', 'bbp2sdData', 'p2sdHeightData', 'bbp3sdData', 'p3sdHeightData', 'bblabels', 'heightToAgeLabels', 'n3sdWeightData', 'p3sdWeightData', 'n2sdWeightData', 'p2sdWeightData', 'n1sdWeightData', 'p1sdWeightData', 'weightToHeightLabels', 'tbValues', 'statusGizi', 'statusTinggi', 'statusWH'));
    }

    private function calculateZScoreWeight($jenis_kelamin, $umur, $berat_badan)
    {
        if ($jenis_kelamin == 'laki-laki') {
            $medianRecord = BBlaki::where('UMUR', $umur)->first();
        } else {
            $medianRecord = BBperempuan::where('UMUR', $umur)->first();
        }
        if ($medianRecord) {
            $medianValue = $medianRecord->MEDIAN;
            $rentangTerdekat = $berat_badan - $medianValue;
            $zScoreFromSD = $rentangTerdekat > 0
                ? ($jenis_kelamin == 'laki-laki' ? BBlaki::where('UMUR', $umur)->pluck('P1SD')->first() : BBperempuan::where('UMUR', $umur)->pluck('P1SD')->first())
                : ($jenis_kelamin == 'laki-laki' ? BBlaki::where('UMUR', $umur)->pluck('N1SD')->first() : BBperempuan::where('UMUR', $umur)->pluck('N1SD')->first());
            $NilaiRentangTerdekat = $zScoreFromSD;
            $penyebut = $berat_badan - $medianValue;
            // dd($penyebut);
            if ($penyebut > 0) {
                return ($penyebut) / ($NilaiRentangTerdekat - $medianValue);
            } else {
                return ($penyebut) / ($medianValue - $NilaiRentangTerdekat);
            }
        }
        return null;
    }

    private function calculateZScoreHeight($jenis_kelamin, $umur, $tinggi_badan)
    {
        if ($jenis_kelamin == 'laki-laki') {
            $medianRecord = TBlaki::where('UMUR', $umur)->first();
        } else {
            $medianRecord = TBperempuan::where('UMUR', $umur)->first();
        }
        if ($medianRecord) {
            $medianValue = $medianRecord->MEDIAN;
            $rentangTerdekat = $tinggi_badan - $medianValue;
            $zScoreFromSD = $rentangTerdekat > 0
                ? ($jenis_kelamin == 'laki-laki' ? TBlaki::where('UMUR', $umur)->pluck('P1SD')->first() : TBperempuan::where('UMUR', $umur)->pluck('P1SD')->first())
                : ($jenis_kelamin == 'laki-laki' ? TBlaki::where('UMUR', $umur)->pluck('N1SD')->first() : TBperempuan::where('UMUR', $umur)->pluck('N1SD')->first());
            $NilaiRentangTerdekat = $zScoreFromSD;
            $penyebut = $tinggi_badan - $medianValue;
            if ($penyebut > 0) {
                return ($penyebut) / ($NilaiRentangTerdekat - $medianValue);
            } else {
                return ($penyebut) / ($medianValue - $NilaiRentangTerdekat);
            }
        }
        return null;
    }

    private function calculateZScoreWH($jenis_kelamin, $tinggi_badan, $berat_badan)
    {
        $roundedHeight = round($tinggi_badan, 0, PHP_ROUND_HALF_UP);
        if ($jenis_kelamin == 'laki-laki') {
            $medianRecord = BbtBlaki::where('TB', $roundedHeight)->first();
        } else {
            $medianRecord = Bbtbperempuan::where('TB', $roundedHeight)->first();
        }
        if ($medianRecord) {
            $medianValue = $medianRecord->MEDIAN;
            $rentangTerdekat = $berat_badan - $medianValue;
            $zScoreFromSD = $rentangTerdekat > 0
                ? ($jenis_kelamin == 'laki-laki' ? BbtBlaki::where('TB', $roundedHeight)->pluck('P1SD')->first() : Bbtbperempuan::where('TB', $roundedHeight)->pluck('P1SD')->first())
                : ($jenis_kelamin == 'laki-laki' ? BbtBlaki::where('TB', $roundedHeight)->pluck('N1SD')->first() : Bbtbperempuan::where('TB', $roundedHeight)->pluck('N1SD')->first());
            $NilaiRentangTerdekat = $zScoreFromSD;
            $penyebut = $berat_badan - $medianValue;
            if ($penyebut > 0) {
                return ($penyebut) / ($NilaiRentangTerdekat - $medianValue);
            } else {
                return ($penyebut) / ($medianValue - $NilaiRentangTerdekat);
            }
        }
        return null;
    }


    private function determineNutritionalStatus($ZScoreWeight)
    {
        if ($ZScoreWeight > 1)
            return "Resiko berat badan lebih";
        if ($ZScoreWeight >= -2 && $ZScoreWeight <= 1)
            return "Berat badan normal";
        if ($ZScoreWeight >= -3 && $ZScoreWeight < -2)
            return "Berat badan kurang";
        return "Berat badan sangat kurang";
    }

    private function determineHeightStatus($ZScoreHeight)
    {
        if ($ZScoreHeight > 3)
            return "Tinggi";
        if ($ZScoreHeight >= -2 && $ZScoreHeight <= 3)
            return "Normal";
        if ($ZScoreHeight > -3 && $ZScoreHeight < -2)
            return "Pendek";
        return "Sangat pendek";
    }

    private function determineWeightHeightStatus($ZScoreWH)
    {
        if ($ZScoreWH > 3)
            return "Obesitas";
        if ($ZScoreWH > 2 && $ZScoreWH <= 3)
            return "Gizi lebih";
        if ($ZScoreWH > 1 && $ZScoreWH <= 2)
            return "Beresiko gizi lebih";
        if ($ZScoreWH > -2 && $ZScoreWH <= 1)
            return "Gizi normal";
        if ($ZScoreWH >= -3 && $ZScoreWH <= -2)
            return "Gizi kurang";
        return "Gizi buruk";
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

        try {
            // Ambil nilai berat_badan dan tinggi_badan dari request
            $berat_badan = $request->berat_badan;
            $tinggi_badan = $request->tinggi_badan;

            $pasien = Pasien::findOrFail($id);
            $jenis_kelamin = $request->jenis_kelamin;
            $umur = $request->umur;

            $statusGizi = "data belum diisi";
            $statusTinggi = "data belum diisi";
            $statusWH = "data belum diisi";

            if ($jenis_kelamin == 'laki-laki') {
                $dataBBPasien = BBlaki::orderBy('UMUR')->get();
                $tbData = TBlaki::orderBy('UMUR')->get();
                $bbtbData = BbtBlaki::orderBy('TB')->get();

                if ($tinggi_badan > 0 && $berat_badan > 0) {
                    $roundedHeight = round($tinggi_badan, 0, PHP_ROUND_HALF_UP);
                    $medianRecord = BbtBlaki::where('TB', $roundedHeight)->first();
                    $medianValue = $medianRecord ? $medianRecord->MEDIAN : null;

                    if ($medianValue !== null) {
                        $rentangTerdekat = $berat_badan - $medianValue;
                        $zScoreFromSD = $rentangTerdekat > 0
                            ? BbtBlaki::where('TB', $roundedHeight)->pluck('P1SD')->first()
                            : BbtBlaki::where('TB', $roundedHeight)->pluck('N1SD')->first();
                        $NilaiRentangTerdekat = $zScoreFromSD;
                        $pembilang = $berat_badan - $medianValue;
                        if ($pembilang > 0) {
                            $ZScoreWeihgtHeight = ($pembilang) / ($NilaiRentangTerdekat - $medianValue);
                        } else {
                            $ZScoreWeihgtHeight = ($pembilang) / ($medianValue - $NilaiRentangTerdekat);
                        }

                        $ZScoreWH = $ZScoreWeihgtHeight;
                    }

                    $medianRecordHeight = TBlaki::where('UMUR', $umur)->first();
                    $medianValueHeight = $medianRecordHeight ? $medianRecordHeight->MEDIAN : null;

                    if ($medianValueHeight !== null) {
                        $rentangTerdekatHeigt = $tinggi_badan - $medianValueHeight;
                        $zScoreFromHeightSD = $rentangTerdekatHeigt > 0
                            ? TBlaki::where('UMUR', $umur)->pluck('P1SD')->first()
                            : TBlaki::where('UMUR', $umur)->pluck('N1SD')->first();
                        $NilaiRentangTerdekatHeight = $zScoreFromHeightSD;
                        $pembilang = $tinggi_badan - $medianValueHeight;
                        if ($pembilang > 0) {
                            $ZScoreHt = ($pembilang) / ($NilaiRentangTerdekatHeight - $medianValueHeight);
                        } else {
                            $ZScoreHt = ($pembilang) / ($medianValueHeight - $NilaiRentangTerdekatHeight);
                        }
                        $ZScoreHeight = $ZScoreHt;
                    }

                    $medianRecordWeight = BBlaki::where('UMUR', $umur)->first();
                    $medianWeightValue = $medianRecordWeight ? $medianRecordWeight->MEDIAN : null;

                    if ($medianWeightValue !== null) {
                        $rentangTerdekatWeight = $berat_badan - $medianWeightValue;
                        $zScoreFromWeightSD = $rentangTerdekatWeight > 0
                            ? BBlaki::where('UMUR', $umur)->pluck('P1SD')->first()
                            : BBlaki::where('UMUR', $umur)->pluck('N1SD')->first();
                        $NilaiRentangTerdekatWeight = $zScoreFromWeightSD;
                        $pembilang = $berat_badan - $medianWeightValue;
                        if ($pembilang > 0) {
                            $ZScoreWt = ($pembilang) / ($NilaiRentangTerdekatWeight - $medianWeightValue);
                        } else {
                            $ZScoreWt = ($pembilang) / ($medianWeightValue - $NilaiRentangTerdekatWeight);
                        }
                        $ZScoreWeight = $ZScoreWt;
                    }

                    $statusGizi = $this->determineNutritionalStatus($ZScoreWeight);
                    $statusTinggi = $this->determineHeightStatus($ZScoreHeight);
                    $statusWH = $this->determineWeightHeightStatus($ZScoreWH);
                } else {
                    $ZScoreWeight = null; // Set ZScore to null if Weight is not greater than 0
                    $ZScoreWH = null; // Set ZScore to null if Weight is not greater than 0
                    $ZScoreHeight = null; // Set ZScore to null if Weight is not greater than 0
                }
            } else {
                $medianRecord = BBperempuan::where('UMUR', $umur)->first();
                $dataBBPasien = BBperempuan::orderBy('UMUR')->get();
                $tbData = TBperempuan::orderBy('UMUR')->get();
                $bbtbData = Bbtbperempuan::orderBy('TB')->get();
                $medianHeight = TBperempuan::where('UMUR', $umur)->first();

                if ($tinggi_badan > 0 && $berat_badan > 0) {
                    $roundedHeight = round($tinggi_badan, 0, PHP_ROUND_HALF_UP);
                    $medianRecord = Bbtbperempuan::where('TB', $roundedHeight)->first();
                    $medianValue = $medianRecord ? $medianRecord->MEDIAN : null;

                    if ($medianValue !== null) {
                        $rentangTerdekat = $berat_badan - $medianValue;
                        $zScoreFromSD = $rentangTerdekat > 0
                            ? Bbtbperempuan::where('TB', $roundedHeight)->pluck('P1SD')->first()
                            : Bbtbperempuan::where('TB', $roundedHeight)->pluck('N1SD')->first();
                        $NilaiRentangTerdekat = $zScoreFromSD;
                        $pembilang = $berat_badan - $medianValue;
                        if ($pembilang > 0) {
                            $ZScoreWeihgtHeight = ($pembilang) / ($NilaiRentangTerdekat - $medianValue);
                        } else {
                            $ZScoreWeihgtHeight = ($pembilang) / ($medianValue - $NilaiRentangTerdekat);
                        }

                        $ZScoreWH = $ZScoreWeihgtHeight;
                    }

                    $medianRecordHeight = TBperempuan::where('UMUR', $umur)->first();
                    $medianValueHeight = $medianRecordHeight ? $medianRecordHeight->MEDIAN : null;

                    if ($medianValueHeight !== null) {
                        $rentangTerdekatHeigt = $tinggi_badan - $medianValueHeight;
                        $zScoreFromHeightSD = $rentangTerdekatHeigt > 0
                            ? TBperempuan::where('UMUR', $umur)->pluck('P1SD')->first()
                            : TBperempuan::where('UMUR', $umur)->pluck('N1SD')->first();
                        $NilaiRentangTerdekatHeight = $zScoreFromHeightSD;
                        $pembilang = $tinggi_badan - $medianValueHeight;
                        if ($pembilang > 0) {
                            $ZScoreHt = ($pembilang) / ($NilaiRentangTerdekatHeight - $medianValueHeight);
                        } else {
                            $ZScoreHt = ($pembilang) / ($medianValueHeight - $NilaiRentangTerdekatHeight);
                        }
                        $ZScoreHeight = $ZScoreHt;
                    }

                    $medianRecordWeight = BBperempuan::where('UMUR', $umur)->first();
                    $medianWeightValue = $medianRecordWeight ? $medianRecordWeight->MEDIAN : null;

                    if ($medianWeightValue !== null) {
                        $rentangTerdekatWeight = $berat_badan - $medianWeightValue;
                        $zScoreFromWeightSD = $rentangTerdekatWeight > 0
                            ? BBperempuan::where('UMUR', $umur)->pluck('P1SD')->first()
                            : BBperempuan::where('UMUR', $umur)->pluck('N1SD')->first();
                        $NilaiRentangTerdekatWeight = $zScoreFromWeightSD;
                        $pembilang = $berat_badan - $medianWeightValue;
                        if ($pembilang > 0) {
                            $ZScoreWt = ($pembilang) / ($NilaiRentangTerdekatWeight - $medianWeightValue);
                        } else {
                            $ZScoreWt = ($pembilang) / ($medianWeightValue - $NilaiRentangTerdekatWeight);
                        }
                        $ZScoreWeight = $ZScoreWt;
                    }

                    $statusGizi = $this->determineNutritionalStatus($ZScoreWeight);
                    $statusTinggi = $this->determineHeightStatus($ZScoreHeight);
                    $statusWH = $this->determineWeightHeightStatus($ZScoreWH);
                } else {
                    $ZScoreWeight = null; // Set ZScore to null if Weight is not greater than 0
                    $ZScoreWH = null; // Set ZScore to null if Weight is not greater than 0
                    $ZScoreHeight = null; // Set ZScore to null if Weight is not greater than 0
                }
            }
            // dd($statusGizi);exit();
            // Simpan data pasien ke database
            Pasien::create([
                'nik' => Pasien::findOrFail($id)->nik,
                'nama' => Pasien::findOrFail($id)->nama,
                'jenis_kelamin' => $jenis_kelamin,
                'tanggal_lahir' => Pasien::findOrFail($id)->tanggal_lahir,
                'tempat_lahir' => Pasien::findOrFail($id)->tempat_lahir,
                'nama_ortu' => Pasien::findOrFail($id)->nama_ortu,
                'email_ortu' => Pasien::findOrFail($id)->email_ortu,
                'umur' => $umur,
                'alamat' => Pasien::findOrFail($id)->alamat,
                'id_location' => Pasien::findOrFail($id)->location->id,
                'tanggal_pengukuran' => now(), // Menggunakan nilai saat ini dari created_at
                'berat_badan' => $berat_badan,
                'tinggi_badan' => $tinggi_badan,
                'status_gizi' => $statusGizi, // Nilai default untuk status gizi
                'status_tinggi' => $statusTinggi, // Nilai default untuk status tinggi
                'kategori' => $statusWH
            ]);

            return redirect()->route('list-pasien')->with('success', 'Data pasien berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data pengukuran');
        }
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

            // Ambil nilai berat_badan dan tinggi_badan dari request
            $berat_badan = $request->berat_badan;
            $tinggi_badan = $request->tinggi_badan;

            $jenis_kelamin = $pengukuran->jenis_kelamin;
            $umur = $pengukuran->umur;

            $statusGizi = "data belum diisi";
            $statusTinggi = "data belum diisi";
            $statusWH = "data belum diisi";

            if ($jenis_kelamin == 'laki-laki') {
                // Logika perhitungan untuk laki-laki seperti di fungsi simpan
                $dataBBPasien = BBlaki::orderBy('UMUR')->get();
                $tbData = TBlaki::orderBy('UMUR')->get();
                $bbtbData = BbtBlaki::orderBy('TB')->get();

                if ($tinggi_badan > 0 && $berat_badan > 0) {
                    $roundedHeight = round($tinggi_badan, 0, PHP_ROUND_HALF_UP);
                    $medianRecord = BbtBlaki::where('TB', $roundedHeight)->first();
                    $medianValue = $medianRecord ? $medianRecord->MEDIAN : null;

                    if ($medianValue !== null) {
                        $rentangTerdekat = $berat_badan - $medianValue;
                        $zScoreFromSD = $rentangTerdekat > 0
                            ? BbtBlaki::where('TB', $roundedHeight)->pluck('P1SD')->first()
                            : BbtBlaki::where('TB', $roundedHeight)->pluck('N1SD')->first();
                        $NilaiRentangTerdekat = $zScoreFromSD;
                        $pembilang = $berat_badan - $medianValue;
                        if ($pembilang > 0) {
                            $ZScoreWeihgtHeight = ($pembilang) / ($NilaiRentangTerdekat - $medianValue);
                        } else {
                            $ZScoreWeihgtHeight = ($pembilang) / ($medianValue - $NilaiRentangTerdekat);
                        }

                        $ZScoreWH = $ZScoreWeihgtHeight;
                    }

                    $medianRecordHeight = TBlaki::where('UMUR', $umur)->first();
                    $medianValueHeight = $medianRecordHeight ? $medianRecordHeight->MEDIAN : null;

                    if ($medianValueHeight !== null) {
                        $rentangTerdekatHeigt = $tinggi_badan - $medianValueHeight;
                        $zScoreFromHeightSD = $rentangTerdekatHeigt > 0
                            ? TBlaki::where('UMUR', $umur)->pluck('P1SD')->first()
                            : TBlaki::where('UMUR', $umur)->pluck('N1SD')->first();
                        $NilaiRentangTerdekatHeight = $zScoreFromHeightSD;
                        $pembilang = $tinggi_badan - $medianValueHeight;
                        if ($pembilang > 0) {
                            $ZScoreHt = ($pembilang) / ($NilaiRentangTerdekatHeight - $medianValueHeight);
                        } else {
                            $ZScoreHt = ($pembilang) / ($medianValueHeight - $NilaiRentangTerdekatHeight);
                        }
                        $ZScoreHeight = $ZScoreHt;
                    }

                    $medianRecordWeight = BBlaki::where('UMUR', $umur)->first();
                    $medianWeightValue = $medianRecordWeight ? $medianRecordWeight->MEDIAN : null;

                    if ($medianWeightValue !== null) {
                        $rentangTerdekatWeight = $berat_badan - $medianWeightValue;
                        $zScoreFromWeightSD = $rentangTerdekatWeight > 0
                            ? BBlaki::where('UMUR', $umur)->pluck('P1SD')->first()
                            : BBlaki::where('UMUR', $umur)->pluck('N1SD')->first();
                        $NilaiRentangTerdekatWeight = $zScoreFromWeightSD;
                        $pembilang = $berat_badan - $medianWeightValue;
                        if ($pembilang > 0) {
                            $ZScoreWt = ($pembilang) / ($NilaiRentangTerdekatWeight - $medianWeightValue);
                        } else {
                            $ZScoreWt = ($pembilang) / ($medianWeightValue - $NilaiRentangTerdekatWeight);
                        }
                        $ZScoreWeight = $ZScoreWt;
                    }

                    $statusGizi = $this->determineNutritionalStatus($ZScoreWeight);
                    $statusTinggi = $this->determineHeightStatus($ZScoreHeight);
                    $statusWH = $this->determineWeightHeightStatus($ZScoreWH);
                } else {
                    $ZScoreWeight = null; // Set ZScore to null if Weight is not greater than 0
                    $ZScoreWH = null; // Set ZScore to null if Weight is not greater than 0
                    $ZScoreHeight = null; // Set ZScore to null if Weight is not greater than 0
                }
            } else {
                // Logika perhitungan untuk perempuan seperti di fungsi simpan
                $medianRecord = BBperempuan::where('UMUR', $umur)->first();
                $dataBBPasien = BBperempuan::orderBy('UMUR')->get();
                $tbData = TBperempuan::orderBy('UMUR')->get();
                $bbtbData = Bbtbperempuan::orderBy('TB')->get();
                $medianHeight = TBperempuan::where('UMUR', $umur)->first();

                if ($tinggi_badan > 0 && $berat_badan > 0) {
                    $roundedHeight = round($tinggi_badan, 0, PHP_ROUND_HALF_UP);
                    $medianRecord = Bbtbperempuan::where('TB', $roundedHeight)->first();
                    $medianValue = $medianRecord ? $medianRecord->MEDIAN : null;

                    if ($medianValue !== null) {
                        $rentangTerdekat = $berat_badan - $medianValue;
                        $zScoreFromSD = $rentangTerdekat > 0
                            ? Bbtbperempuan::where('TB', $roundedHeight)->pluck('P1SD')->first()
                            : Bbtbperempuan::where('TB', $roundedHeight)->pluck('N1SD')->first();
                        $NilaiRentangTerdekat = $zScoreFromSD;
                        $pembilang = $berat_badan - $medianValue;
                        if ($pembilang > 0) {
                            $ZScoreWeihgtHeight = ($pembilang) / ($NilaiRentangTerdekat - $medianValue);
                        } else {
                            $ZScoreWeihgtHeight = ($pembilang) / ($medianValue - $NilaiRentangTerdekat);
                        }

                        $ZScoreWH = $ZScoreWeihgtHeight;
                    }

                    $medianRecordHeight = TBperempuan::where('UMUR', $umur)->first();
                    $medianValueHeight = $medianRecordHeight ? $medianRecordHeight->MEDIAN : null;

                    if ($medianValueHeight !== null) {
                        $rentangTerdekatHeigt = $tinggi_badan - $medianValueHeight;
                        $zScoreFromHeightSD = $rentangTerdekatHeigt > 0
                            ? TBperempuan::where('UMUR', $umur)->pluck('P1SD')->first()
                            : TBperempuan::where('UMUR', $umur)->pluck('N1SD')->first();
                        $NilaiRentangTerdekatHeight = $zScoreFromHeightSD;
                        $pembilang = $tinggi_badan - $medianValueHeight;
                        if ($pembilang > 0) {
                            $ZScoreHt = ($pembilang) / ($NilaiRentangTerdekatHeight - $medianValueHeight);
                        } else {
                            $ZScoreHt = ($pembilang) / ($medianValueHeight - $NilaiRentangTerdekatHeight);
                        }
                        $ZScoreHeight = $ZScoreHt;
                    }

                    $medianRecordWeight = BBperempuan::where('UMUR', $umur)->first();
                    $medianWeightValue = $medianRecordWeight ? $medianRecordWeight->MEDIAN : null;

                    if ($medianWeightValue !== null) {
                        $rentangTerdekatWeight = $berat_badan - $medianWeightValue;
                        $zScoreFromWeightSD = $rentangTerdekatWeight > 0
                            ? BBperempuan::where('UMUR', $umur)->pluck('P1SD')->first()
                            : BBperempuan::where('UMUR', $umur)->pluck('N1SD')->first();
                        $NilaiRentangTerdekatWeight = $zScoreFromWeightSD;
                        $pembilang = $berat_badan - $medianWeightValue;
                        if ($pembilang > 0) {
                            $ZScoreWt = ($pembilang) / ($NilaiRentangTerdekatWeight - $medianWeightValue);
                        } else {
                            $ZScoreWt = ($pembilang) / ($medianWeightValue - $NilaiRentangTerdekatWeight);
                        }
                        $ZScoreWeight = $ZScoreWt;
                    }

                    $statusGizi = $this->determineNutritionalStatus($ZScoreWeight);
                    $statusTinggi = $this->determineHeightStatus($ZScoreHeight);
                    $statusWH = $this->determineWeightHeightStatus($ZScoreWH);
                } else {
                    $ZScoreWeight = null; // Set ZScore to null if Weight is not greater than 0
                    $ZScoreWH = null; // Set ZScore to null if Weight is not greater than 0
                    $ZScoreHeight = null; // Set ZScore to null if Weight is not greater than 0
                }
            }

            // Update data pengukuran dengan data yang dikirimkan dari form
            $pengukuran->berat_badan = $berat_badan;
            $pengukuran->tinggi_badan = $tinggi_badan;
            $pengukuran->status_gizi = $statusGizi;
            $pengukuran->status_tinggi = $statusTinggi;
            $pengukuran->kategori = $statusWH;
            $pengukuran->save();

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
