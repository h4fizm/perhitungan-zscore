<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class LokasiController extends Controller
{
    public function showChart()
    {
        // Mengambil data kelurahan dari database
        $locations = Location::all();

        // Menyiapkan array untuk menyimpan data persentase pasien dan ID lokasi
        $kelurahanNames = [];
        $kelurahanIds = [];
        $obesitasData = [];
        $stuntingData = [];
        $normalData = [];

        foreach ($locations as $location) {
            // Mengambil pasien unik berdasarkan NIK terbaru untuk setiap kelurahan
            $uniquePatients = Pasien::whereIn('id', function ($query) use ($location) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('pasien')
                    ->where('id_location', $location->id)
                    ->groupBy('nik');
            })->get();

            // Menghitung total pasien dan jumlah pasien per kategori
            $totalPasien = $uniquePatients->count();
            $totalNormal = $uniquePatients->where('kategori', 'Normal')->count();
            $totalStunting = $uniquePatients->whereIn('kategori', ['Kurus', 'Sangat Kurus'])->count();
            $totalObesitas = $uniquePatients->where('kategori', 'Gemuk')->count();

            // Menghitung persentase berdasarkan kategori gizi
            $obesitasPercent = $totalPasien > 0 ? ($totalObesitas / $totalPasien) * 100 : 0;
            $stuntingPercent = $totalPasien > 0 ? ($totalStunting / $totalPasien) * 100 : 0;
            $normalPercent = $totalPasien > 0 ? ($totalNormal / $totalPasien) * 100 : 0;

            // Menyimpan data ke array
            $kelurahanNames[] = $location->name_location;
            $kelurahanIds[] = $location->id; // Menyimpan ID lokasi
            $obesitasData[] = $obesitasPercent;
            $stuntingData[] = $stuntingPercent;
            $normalData[] = $normalPercent;
        }

        // Passing data ke view
        return view('menu.grafik', compact('kelurahanNames', 'kelurahanIds', 'obesitasData', 'stuntingData', 'normalData'));
    }


    public function index()
    {
        $locations = Location::all();
        $stuntingLocations = [];

        foreach ($locations as $location) {
            // Get the unique patients with the latest data for each NIK in the location
            $uniquePatients = Pasien::whereIn('id', function ($query) use ($location) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('pasien')
                    ->where('id_location', $location->id)
                    ->groupBy('nik');
            })->get();

            // Calculate totals based on unique patients
            $totalPasien = $uniquePatients->count();
            $totalNormal = $uniquePatients->where('kategori', 'Normal')->count();
            $totalStunting = $uniquePatients->whereIn('kategori', ['Kurus', 'Sangat Kurus'])->count();
            $totalObesitas = $uniquePatients->where('kategori', 'Gemuk')->count();

            // Determine the value category based on the counts of patients
            $value = $this->calculateValue($totalNormal, $totalStunting, $totalObesitas);

            // Update location value in the database
            $location->update(['value' => $value]);

            // Assign other data to location object
            $location->jumlah_pasien = $totalPasien;
            $location->jumlah_stunting = $totalStunting;
            $location->jumlah_normal = $totalNormal;
            $location->jumlah_obesitas = $totalObesitas;

            // Collect locations with high stunting rates
            if ($value == 1) {
                $stuntingLocations[] = $location->name_location;
            }
        }

        // // Send email if there are locations with high stunting rates and the email hasn't been sent yet for this condition
        // if (!empty($stuntingLocations)) {
        //     $this->sendStuntingWarningEmailOnce($stuntingLocations);
        // }

        return view('menu.pemetaan-lokasi', compact('locations'));
    }

    public function manajemen()
    {
        $locations = Location::all();
        $stuntingLocations = [];

        foreach ($locations as $location) {
            // Get the unique patients with the latest data for each NIK in the location
            $uniquePatients = Pasien::whereIn('id', function ($query) use ($location) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('pasien')
                    ->where('id_location', $location->id)
                    ->groupBy('nik');
            })->get();

            // Calculate totals based on unique patients
            $totalPasien = $uniquePatients->count();
            $totalNormal = $uniquePatients->where('kategori', 'Normal')->count();
            $totalStunting = $uniquePatients->whereIn('kategori', ['Kurus', 'Sangat Kurus'])->count();
            $totalObesitas = $uniquePatients->where('kategori', 'Gemuk')->count();

            // Determine the value category based on the counts of patients
            $value = $this->calculateValue($totalNormal, $totalStunting, $totalObesitas);

            // Update location value in the database
            $location->update(['value' => $value]);

            // Assign other data to location object
            $location->jumlah_pasien = $totalPasien;
            $location->jumlah_stunting = $totalStunting;
            $location->jumlah_normal = $totalNormal;
            $location->jumlah_obesitas = $totalObesitas;

            // Collect locations with high stunting rates
            if ($value == 1) {
                $stuntingLocations[] = $location->name_location;
            }
        }

        // Send email if there are locations with high stunting rates and the email hasn't been sent yet for this condition
        // if (!empty($stuntingLocations)) {
        //     $this->sendStuntingWarningEmailOnce($stuntingLocations);
        // }

        return view('menu.manajemen-lokasi', compact('locations'));
    }


    // New function to calculate the value based on counts of patients
    private function calculateValue($totalNormal, $totalStunting, $totalObesitas)
    {
        if ($totalNormal > $totalStunting && $totalNormal > $totalObesitas) {
            return 3; // Low
        } elseif ($totalNormal == $totalStunting || $totalNormal == $totalObesitas) {
            return 2; // Medium
        } else {
            return 1; // High
        }
    }

    // New function to send stunting warning email once based on latest condition
    // private function sendStuntingWarningEmailOnce($stuntingLocations)
    // {
    //     $cacheKey = 'last_stunting_email_locations';
    //     $lastStuntingEmailLocations = Cache::get($cacheKey, []);

    //     // Check if the current stunting locations are different from the last cached locations
    //     if (array_diff($stuntingLocations, $lastStuntingEmailLocations) || array_diff($lastStuntingEmailLocations, $stuntingLocations)) {
    //         $emailContent = "Yth. Bapak/Ibu,\n\nKami ingin memberitahukan bahwa jumlah pasien dengan status stunting telah mencapai tingkat yang tinggi di beberapa kelurahan. Berikut adalah daftar kelurahan yang memiliki status stunting dan obesitas tinggi:\n\n" . implode("\n", $stuntingLocations) . "\n\nKami sangat mengkhawatirkan kondisi ini dan berharap dapat segera mengambil tindakan yang diperlukan untuk menanggulangi masalah stunting di wilayah ini.\n\nTerima kasih atas perhatian dan kerjasamanya.\n\nSalam,\nTim Kesehatan";

    //         Mail::raw($emailContent, function ($message) {
    //             $message->to('rpltekmed@gmail.com')
    //                 ->subject('Peringatan Tingkat Stunting Tinggi di Beberapa Kelurahan');
    //         });

    //         // Update the last stunting email locations in cache
    //         Cache::put($cacheKey, $stuntingLocations, now()->addDay()); // Cache for 1 day
    //     }
    // }
}
