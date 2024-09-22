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

                $statusGizi[] = $measurement->status_gizi;
                $statusTinggi[] = $measurement->status_tinggi;
                $statusWH[] = $measurement->kategori;

                // $statusGizi[] = $this->determineNutritionalStatus($ZScoreWeight);
                // $statusTinggi[] = $this->determineHeightStatus($ZScoreHeight);
                // $statusWH[] = $this->determineWeightHeightStatus($ZScoreWH);

                // Get the latest values from the arrays
                // $latestStatusWH = end($statusWH);
                // $latestStatusGizi = end($statusGizi);

                // if (in_array($latestStatusWH, ['Beresiko gizi lebih', 'Gizi lebih', 'Obesitas']) && in_array($latestStatusGizi, ["Berat badan sangat kurang", "Berat badan kurang"])) {
                //     $statusWH[key($statusWH)] = "Gizi kurang";
                // } else if (in_array($latestStatusWH, ['Gizi kurang', 'Gizi buruk']) && in_array($latestStatusGizi, ["Resiko berat badan lebih"])) {
                //     $statusWH[key($statusWH)] = "Gizi lebih";
                // }
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
            $whoData = BBlaki::where('UMUR', $umur)->first();
        } else {
            $whoData = BBperempuan::where('UMUR', $umur)->first();
        }

        $zScore = $this->calculateZScore($berat_badan, $whoData);
        return $zScore;
    }

    private function calculateZScore($observedValue, $whoData)
    {
        // Interpolation logic to calculate Z-score
        if ($observedValue <= $whoData->N3SD) {
            return -3;
        } elseif ($observedValue > $whoData->N3SD && $observedValue <= $whoData->N2SD) {
            return -3 + ($observedValue - $whoData->N3SD) / ($whoData->N2SD - $whoData->N3SD);
        } elseif ($observedValue > $whoData->N2SD && $observedValue <= $whoData->MEDIAN) {
            return -2 + ($observedValue - $whoData->N2SD) / ($whoData->MEDIAN - $whoData->N2SD);
        } elseif ($observedValue > $whoData->MEDIAN && $observedValue <= $whoData->P1SD) {
            return 0 + ($observedValue - $whoData->MEDIAN) / ($whoData->P1SD - $whoData->MEDIAN);
        } elseif ($observedValue > $whoData->P1SD && $observedValue <= $whoData->P2SD) {
            return 1 + ($observedValue - $whoData->P1SD) / ($whoData->P2SD - $whoData->P1SD);
        } elseif ($observedValue > $whoData->P2SD && $observedValue <= $whoData->P3SD) {
            return 2 + ($observedValue - $whoData->P2SD) / ($whoData->P3SD - $whoData->P2SD);
        } else {
            return 3;
        }
    }

    private function determineNutritionalStatus($jenis_kelamin, $umur, $berat_badan)
    {
        $zScoreWeight = $this->calculateZScoreWeight($jenis_kelamin, $umur, $berat_badan);

        if ($zScoreWeight >= 1) {
            return "Resiko berat badan lebih";
        } elseif ($zScoreWeight >= -2 && $zScoreWeight < 1) {
            return "Berat badan normal";
        } elseif ($zScoreWeight > -3 && $zScoreWeight < -2) {
            return "Berat badan kurang";
        } else {
            return "Berat badan sangat kurang";
        }
    }

    private function calculateZScoreHeight($jenis_kelamin, $umur, $tinggi_badan)
    {
        if ($jenis_kelamin == 'laki-laki') {
            $whoData = TBlaki::where('UMUR', $umur)->first();
        } else {
            $whoData = TBperempuan::where('UMUR', $umur)->first();
        }

        $zScore = $this->calculateZScore($tinggi_badan, $whoData);
        return $zScore;
    }

    private function determineHeightStatus($jenis_kelamin, $umur, $tinggi_badan)
    {
        $zScoreHeight = $this->calculateZScoreHeight($jenis_kelamin, $umur, $tinggi_badan);

        if ($zScoreHeight >= 3) {
            return "Tinggi";
        } elseif ($zScoreHeight >= -2 && $zScoreHeight < 3) {
            return "Normal";
        } elseif ($zScoreHeight > -3 && $zScoreHeight < -2) {
            return "Pendek";
        } else {
            return "Sangat pendek";
        }
    }

    private function calculateZScoreWH($jenis_kelamin, $tinggi_badan, $berat_badan)
    {
        $roundedHeight = round($tinggi_badan, 0, PHP_ROUND_HALF_UP);

        if ($jenis_kelamin == 'laki-laki') {
            $whoData = BbtBlaki::where('TB', $roundedHeight)->first();
        } else {
            $whoData = Bbtbperempuan::where('TB', $roundedHeight)->first();
        }

        $zScore = $this->calculateZScore($berat_badan, $whoData);
        return $zScore;
    }

    private function determineWeightHeightStatus($jenis_kelamin, $tinggi_badan, $berat_badan)
    {
        $zScoreWH = $this->calculateZScoreWH($jenis_kelamin, $tinggi_badan, $berat_badan);

        if ($zScoreWH >= 3) {
            return "Obesitas";
        } elseif ($zScoreWH >= 2 && $zScoreWH < 3) {
            return "Gizi lebih";
        } elseif ($zScoreWH >= 1 && $zScoreWH < 2) {
            return "Beresiko gizi lebih";
        } elseif ($zScoreWH >= -2 && $zScoreWH < 1) {
            return "Gizi baik";
        } elseif ($zScoreWH > -3 && $zScoreWH < -2) {
            return "Gizi kurang";
        } else {
            return "Gizi buruk";
        }
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

        return view('menu.tambah-pengukuran', compact('pasien', 'jenis_kelamin', 'faskes', 'id', 'umurOptions', 'umur', 'tanggal_lahir'));
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

                    $statusGizi = $this->determineNutritionalStatus($jenis_kelamin, $umur, $berat_badan);
                    $statusTinggi = $this->determineHeightStatus($jenis_kelamin, $umur, $tinggi_badan);
                    $statusWH = $this->determineWeightHeightStatus($jenis_kelamin, $tinggi_badan, $berat_badan);
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

                    $statusGizi = $this->determineNutritionalStatus($jenis_kelamin, $umur, $berat_badan);
                    $statusTinggi = $this->determineHeightStatus($jenis_kelamin, $umur, $tinggi_badan);
                    $statusWH = $this->determineWeightHeightStatus($jenis_kelamin, $tinggi_badan, $berat_badan);
                } else {
                    $ZScoreWeight = null; // Set ZScore to null if Weight is not greater than 0
                    $ZScoreWH = null; // Set ZScore to null if Weight is not greater than 0
                    $ZScoreHeight = null; // Set ZScore to null if Weight is not greater than 0
                }
            }

            if (in_array($statusWH, ['Gizi baik', 'Beresiko gizi lebih', 'Gizi lebih', 'Obesitas']) && in_array($statusGizi, ["Berat badan sangat kurang", "Berat badan kurang"])) {
                $statusWH = "Gizi kurang";
            } else if (in_array($statusWH, ['Gizi baik', 'Gizi kurang', 'Gizi buruk']) && in_array($statusGizi, ["Resiko berat badan lebih"])) {
                $statusWH = "Gizi lebih";
            }

            $tanggal_pengukuran = Carbon::parse($request->tanggal_pengukuran);

            // Simpan data pasien ke database
            Pasien::create([
                'nik' => $pasien->nik,
                'no_rekam_medis' => $pasien->no_rekam_medis,
                'nama' => $pasien->nama,
                'jenis_kelamin' => $jenis_kelamin,
                'tanggal_lahir' => $pasien->tanggal_lahir,
                'tempat_lahir' => $pasien->tempat_lahir,
                'nama_ortu' => $pasien->nama_ortu,
                'email_ortu' => $pasien->email_ortu,
                'umur' => $umur,
                'alamat' => $pasien->alamat,
                'id_location' => $pasien->location->id,
                'tanggal_pengukuran' => $tanggal_pengukuran,
                'berat_badan' => $berat_badan,
                'tinggi_badan' => $tinggi_badan,
                'status_gizi' => $statusGizi, // Nilai default untuk status gizi
                'status_tinggi' => $statusTinggi, // Nilai default untuk status tinggi
                'kategori' => $statusWH,
                'updated_at' => $tanggal_pengukuran
            ]);

            $hasil = "ZBB: " . $ZScoreWeight . ", ZTB: " . $ZScoreHeight . ", ZBBTB: " . $ZScoreWH;
            $hasil = $hasil . " | " . $statusGizi . ", " . $statusTinggi . ", " . $statusWH;

            return redirect()->route('list-pasien')->with('success', $hasil);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data pengukuran');
        }
    }

    public function edit($id)
    {
        $pengukuran = Pasien::findOrFail($id);
        
        // Get the original patient record (the one with the actual birth date)
        $originalPasien = Pasien::where('nik', $pengukuran->nik)
                                ->orderBy('created_at', 'asc')
                                ->first();

        $tanggal_lahir = Carbon::parse($originalPasien->tanggal_lahir);
        $tanggal_pengukuran = Carbon::parse($pengukuran->tanggal_pengukuran);

        return view('menu.edit-pengukuran', compact('pengukuran', 'id', 'tanggal_lahir', 'tanggal_pengukuran'));
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
            // Ambil nilai dari request
            $berat_badan = $request->berat_badan;
            $tinggi_badan = $request->tinggi_badan;
            $tanggal_pengukuran = Carbon::parse($request->tanggal_pengukuran);
            $umur = $request->umur;

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

                        // dd($rentangTerdekat, $zScoreFromSD, $pembilang, $medianValue);

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

                    $statusGizi = $this->determineNutritionalStatus($jenis_kelamin, $umur, $berat_badan);
                    $statusTinggi = $this->determineHeightStatus($jenis_kelamin, $umur, $tinggi_badan);
                    $statusWH = $this->determineWeightHeightStatus($jenis_kelamin, $tinggi_badan, $berat_badan);
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
                    
                    $statusGizi = $this->determineNutritionalStatus($jenis_kelamin, $umur, $berat_badan);
                    $statusTinggi = $this->determineHeightStatus($jenis_kelamin, $umur, $tinggi_badan);
                    $statusWH = $this->determineWeightHeightStatus($jenis_kelamin, $tinggi_badan, $berat_badan);
                } else {
                    $ZScoreWeight = null; // Set ZScore to null if Weight is not greater than 0
                    $ZScoreWH = null; // Set ZScore to null if Weight is not greater than 0
                    $ZScoreHeight = null; // Set ZScore to null if Weight is not greater than 0
                }
            }

            if (in_array($statusWH, ['Gizi baik', 'Beresiko gizi lebih', 'Gizi lebih', 'Obesitas']) && in_array($statusGizi, ["Berat badan sangat kurang", "Berat badan kurang"])) {
                // BB Normal, TB Pendek, BBTB Obesitas = Stunting
                // BB Kurang, TB Normal
                $statusWH = "Gizi kurang";
            } else if (in_array($statusWH, ['Gizi baik', 'Gizi kurang', 'Gizi buruk']) && in_array($statusGizi, ["Resiko berat badan lebih"])) {
                // BB Lebih, TB Normal = Obesitas
                // BB Lebih, TB 
                $statusWH = "Gizi lebih";
            }

            // Update data pengukuran dengan data yang dikirimkan dari form
            $pengukuran->berat_badan = $berat_badan;
            $pengukuran->tinggi_badan = $tinggi_badan;
            $pengukuran->tanggal_pengukuran = $tanggal_pengukuran;
            $pengukuran->umur = $umur;
            $pengukuran->status_gizi = $statusGizi;
            $pengukuran->status_tinggi = $statusTinggi;
            $pengukuran->kategori = $statusWH;
            $pengukuran->updated_at = $tanggal_pengukuran;
            $pengukuran->save();

            $ZScoreWeight = $this->calculateZScoreWeight($jenis_kelamin, $umur, $berat_badan);
            $ZScoreHeight = $this->calculateZScoreHeight($jenis_kelamin, $umur, $tinggi_badan);
            $ZScoreWH = $this->calculateZScoreWH($jenis_kelamin, $tinggi_badan, $berat_badan);

            // Redirect kembali ke halaman edit dengan pesan sukses
            $hasil = "ZBB: " . $ZScoreWeight . ", ZTB: " . $ZScoreHeight . ", ZBBTB: " . $ZScoreWH;
            $hasil = $hasil . " | " . $statusGizi . ", " . $statusTinggi . ", " . $statusWH;;
            return redirect()->back()->with('success', $hasil);
            // return redirect()->back()->with('success', 'Data pengukuran berhasil diperbarui');
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

    public function bulkAddPengukuranForm()
    {
        return view('menu.bulk-add-pengukuran');
    }

    public function bulkAddPengukuran(Request $request)
    {
        $pasien = Pasien::findOrFail($request->id);
        $startDate = now();

        // Initial and final values for weight and height
        $initialWeight = 3.0; // 3 kg
        $finalWeight = 25.0; // 25 kg
        $initialHeight = 45.0; // 45 cm
        $finalHeight = 110.0; // 110 cm

        for ($umur = 0; $umur <= 60; $umur++) {
            $date = $startDate->copy()->addMonths($umur);

            $berat_badan = $request->input("berat_badan.$umur", null);
            $tinggi_badan = $request->input("tinggi_badan.$umur", null);

            if ($request->has('randomize_all') || $request->has("randomize.$umur")) {
                // Calculate linear progression
                $weightProgression = $initialWeight + ($finalWeight - $initialWeight) * ($umur / 60);
                $heightProgression = $initialHeight + ($finalHeight - $initialHeight) * ($umur / 60);

                // Add some randomness (±10% of the progression)
                $weightVariation = $weightProgression * 0.1;
                $heightVariation = $heightProgression * 0.1;

                $berat_badan = round(rand($weightProgression - $weightVariation, $weightProgression + $weightVariation) * 100) / 100;
                $tinggi_badan = round(rand($heightProgression - $heightVariation, $heightProgression + $heightVariation) * 100) / 100;

                // Ensure the values don't exceed the limits
                $berat_badan = max(min($berat_badan, 25.0), $initialWeight);
                $tinggi_badan = max(min($tinggi_badan, 120.0), $initialHeight);
            }

            if ($berat_badan !== null && $tinggi_badan !== null) {
                $jenis_kelamin = $pasien->jenis_kelamin;

                $statusGizi = "data belum diisi";
                $statusTinggi = "data belum diisi";
                $statusWH = "data belum diisi";

                if ($jenis_kelamin == 'laki-laki') {
                    $dataBBPasien = BBlaki::orderBy('UMUR')->get();
                    $tbData = TBlaki::orderBy('UMUR')->get();
                    $bbtbData = BbtBlaki::orderBy('TB')->get();
                } else {
                    $dataBBPasien = BBperempuan::orderBy('UMUR')->get();
                    $tbData = TBperempuan::orderBy('UMUR')->get();
                    $bbtbData = Bbtbperempuan::orderBy('TB')->get();
                }

                if ($tinggi_badan > 0 && $berat_badan > 0) {
                    $roundedHeight = round($tinggi_badan, 0, PHP_ROUND_HALF_UP);
                    $medianRecord = $jenis_kelamin == 'laki-laki' ? BbtBlaki::where('TB', $roundedHeight)->first() : Bbtbperempuan::where('TB', $roundedHeight)->first();
                    $medianValue = $medianRecord ? $medianRecord->MEDIAN : null;

                    if ($medianValue !== null) {
                        $rentangTerdekat = $berat_badan - $medianValue;
                        $zScoreFromSD = $rentangTerdekat > 0
                            ? ($jenis_kelamin == 'laki-laki' ? BbtBlaki::where('TB', $roundedHeight)->pluck('P1SD')->first() : Bbtbperempuan::where('TB', $roundedHeight)->pluck('P1SD')->first())
                            : ($jenis_kelamin == 'laki-laki' ? BbtBlaki::where('TB', $roundedHeight)->pluck('N1SD')->first() : Bbtbperempuan::where('TB', $roundedHeight)->pluck('N1SD')->first());
                        $NilaiRentangTerdekat = $zScoreFromSD;
                        $pembilang = $berat_badan - $medianValue;
                        $ZScoreWH = $pembilang > 0 ? $pembilang / ($NilaiRentangTerdekat - $medianValue) : $pembilang / ($medianValue - $NilaiRentangTerdekat);
                    }

                    $medianRecordHeight = $jenis_kelamin == 'laki-laki' ? TBlaki::where('UMUR', $umur)->first() : TBperempuan::where('UMUR', $umur)->first();
                    $medianValueHeight = $medianRecordHeight ? $medianRecordHeight->MEDIAN : null;

                    if ($medianValueHeight !== null) {
                        $rentangTerdekatHeight = $tinggi_badan - $medianValueHeight;
                        $zScoreFromHeightSD = $rentangTerdekatHeight > 0
                            ? ($jenis_kelamin == 'laki-laki' ? TBlaki::where('UMUR', $umur)->pluck('P1SD')->first() : TBperempuan::where('UMUR', $umur)->pluck('P1SD')->first())
                            : ($jenis_kelamin == 'laki-laki' ? TBlaki::where('UMUR', $umur)->pluck('N1SD')->first() : TBperempuan::where('UMUR', $umur)->pluck('N1SD')->first());
                        $NilaiRentangTerdekatHeight = $zScoreFromHeightSD;
                        $pembilang = $tinggi_badan - $medianValueHeight;
                        $ZScoreHeight = $pembilang > 0 ? $pembilang / ($NilaiRentangTerdekatHeight - $medianValueHeight) : $pembilang / ($medianValueHeight - $NilaiRentangTerdekatHeight);
                    }

                    $medianRecordWeight = $jenis_kelamin == 'laki-laki' ? BBlaki::where('UMUR', $umur)->first() : BBperempuan::where('UMUR', $umur)->first();
                    $medianWeightValue = $medianRecordWeight ? $medianRecordWeight->MEDIAN : null;

                    if ($medianWeightValue !== null) {
                        $rentangTerdekatWeight = $berat_badan - $medianWeightValue;
                        $zScoreFromWeightSD = $rentangTerdekatWeight > 0
                            ? ($jenis_kelamin == 'laki-laki' ? BBlaki::where('UMUR', $umur)->pluck('P1SD')->first() : BBperempuan::where('UMUR', $umur)->pluck('P1SD')->first())
                            : ($jenis_kelamin == 'laki-laki' ? BBlaki::where('UMUR', $umur)->pluck('N1SD')->first() : BBperempuan::where('UMUR', $umur)->pluck('N1SD')->first());
                        $NilaiRentangTerdekatWeight = $zScoreFromWeightSD;
                        $pembilang = $berat_badan - $medianWeightValue;
                        $ZScoreWeight = $pembilang > 0 ? $pembilang / ($NilaiRentangTerdekatWeight - $medianWeightValue) : $pembilang / ($medianWeightValue - $NilaiRentangTerdekatWeight);
                    }

                    $statusGizi = $this->determineNutritionalStatus($jenis_kelamin, $umur, $berat_badan);
                    $statusTinggi = $this->determineHeightStatus($jenis_kelamin, $umur, $tinggi_badan);
                    $statusWH = $this->determineWeightHeightStatus($jenis_kelamin, $tinggi_badan, $berat_badan);

                    if (in_array($statusWH, ['Gizi baik', 'Beresiko gizi lebih', 'Gizi lebih', 'Obesitas']) && in_array($statusGizi, ["Berat badan sangat kurang", "Berat badan kurang"])) {
                        $statusWH = "Gizi kurang";
                    } else if (in_array($statusWH, ['Gizi baik', 'Gizi kurang', 'Gizi buruk']) && in_array($statusGizi, ["Resiko berat badan lebih"])) {
                        $statusWH = "Gizi lebih";
                    }
                }

                Pasien::create([
                    'nik' => $pasien->nik,
                    'nama' => $pasien->nama,
                    'jenis_kelamin' => $jenis_kelamin,
                    'tanggal_lahir' => $pasien->tanggal_lahir,
                    'tempat_lahir' => $pasien->tempat_lahir,
                    'nama_ortu' => $pasien->nama_ortu,
                    'email_ortu' => $pasien->email_ortu,
                    'umur' => $umur,
                    'alamat' => $pasien->alamat,
                    'id_location' => $pasien->id_location,
                    'tanggal_pengukuran' => $date,
                    'berat_badan' => $berat_badan,
                    'tinggi_badan' => $tinggi_badan,
                    'status_gizi' => $statusGizi,
                    'status_tinggi' => $statusTinggi,
                    'kategori' => $statusWH,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Bulk data added successfully!');
    }
}
