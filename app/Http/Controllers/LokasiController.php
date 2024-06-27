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
            $totalNormal = $uniquePatients->where('status_gizi', 'normal')->count();
            $totalStunting = $uniquePatients->where('status_gizi', 'stunting')->count();
            $totalObesitas = $uniquePatients->where('status_gizi', 'obesitas')->count();

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
            $totalNormal = $uniquePatients->where('status_gizi', 'normal')->count();
            $totalStunting = $uniquePatients->where('status_gizi', 'stunting')->count();
            $totalObesitas = $uniquePatients->where('status_gizi', 'obesitas')->count();

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
    //         $emailContent = "Yth. Bapak/Ibu,\n\nKami ingin memberitahukan bahwa jumlah pasien dengan status stunting telah mencapai tingkat yang tinggi di beberapa kelurahan. Berikut adalah daftar kelurahan yang memiliki status stunting tinggi:\n\n" . implode("\n", $stuntingLocations) . "\n\nKami sangat mengkhawatirkan kondisi ini dan berharap dapat segera mengambil tindakan yang diperlukan untuk menanggulangi masalah stunting di wilayah ini.\n\nTerima kasih atas perhatian dan kerjasamanya.\n\nSalam,\nTim Kesehatan";

    //         Mail::raw($emailContent, function ($message) {
    //             $message->to('farelhafiz52@gmail.com')
    //                 ->subject('Peringatan Tingkat Stunting Tinggi di Beberapa Kelurahan');
    //         });

    //         // Update the last stunting email locations in cache
    //         Cache::put($cacheKey, $stuntingLocations, now()->addDay()); // Cache for 1 day
    //     }
    // }
}
