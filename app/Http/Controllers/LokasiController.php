<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Pasien;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

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
            $totalNormal = $uniquePatients->where('kategori', 'Gizi normal')->count();
            $totalStunting = $uniquePatients->whereIn('kategori', ['Gizi kurang', 'Gizi buruk'])->count();
            $totalObesitas = $uniquePatients->whereIn('kategori', ['Beresiko gizi lebih', 'Gizi lebih', 'Obesitas'])->count();

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
            $totalNormal = $uniquePatients->where('kategori', 'Gizi normal')->count();
            $totalStunting = $uniquePatients->whereIn('kategori', ['Gizi kurang', 'Gizi buruk'])->count();
            $totalObesitas = $uniquePatients->whereIn('kategori', ['Beresiko gizi lebih', 'Gizi lebih', 'Obesitas'])->count();

            // dd($uniquePatients);

            // Determine the value category based on the counts of patients
            $value = $this->calculateValue($totalNormal, $totalStunting, $totalObesitas);

            // Update location value in the database
            $location->update(['value' => $value]);

            // Assign other data to location object
            $location->jumlah_pasien = $totalPasien;
            $location->jumlah_stunting = $totalStunting;
            $location->jumlah_normal = $totalNormal;
            $location->jumlah_obesitas = $totalObesitas;
        }

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
        }

        return view('menu.manajemen-lokasi', compact('locations'));
    }


    // New function to calculate the value based on counts of patients
    public static function calculateValue($totalNormal, $totalStunting, $totalObesitas)
    {
        if (($totalNormal > $totalStunting && $totalNormal > $totalObesitas) || $totalNormal + $totalObesitas + $totalStunting == 0) {
            return 3; // Low
        } elseif ($totalNormal == $totalStunting || $totalNormal == $totalObesitas) {
            return 2; // Medium
        } else {
            return 1; // High
        }
    }

    // New function to calculate the stunting severity based on counts of patients
    public static function calculateStuntingSeverity($totalNormal, $totalStunting)
    {
        if ($totalNormal > $totalStunting || $totalNormal + $totalStunting == 0) {
            return 3; // Low
        } else {
            return 1; // High
        }
    }

    // New function to send stunting warning email once based on latest condition
    public static function sendStuntingWarningEmailOnce($stuntingLocations, $forceSend)
    {
        $cacheKey = 'last_stunting_email_locations';
        $lastStuntingEmailLocations = Cache::get($cacheKey, []);

        // Check if the current stunting locations are different from the last cached locations
        if (array_diff($stuntingLocations, $lastStuntingEmailLocations) || array_diff($lastStuntingEmailLocations, $stuntingLocations) || $forceSend == "kirim") {
            $emailContentData = [
                'stuntingLocations' => $stuntingLocations,
            ];
            
            $uniqueEmails = array_merge(
                Pasien::distinct()->pluck('email_ortu')->toArray(), // Email orang tua
                User::distinct()->pluck('email')->toArray() // Email pengguna (admin, operator, user)
            );
            $additionalRecipients  = ['humamaziz03@gmail.com']; // Email tambahan
            $recipients = array_filter(array_merge($uniqueEmails, $additionalRecipients));
            
            Mail::send('emails.stunting_alert', $emailContentData, function ($message) use ($recipients) {
                $message->to($recipients)
                    ->subject('Peringatan Tingkat Stunting Tinggi di Beberapa Kelurahan');
            });

            // Update the last stunting email locations in cache
            Cache::put($cacheKey, $stuntingLocations, now()->addDay()); // Cache for 1 day
        }
    }

    public function testEmail()
    {
        // $cacheKey = 'last_stunting_email_locations';
        // $lastStuntingEmailLocations = Cache::get($cacheKey, []);

        // Check if the current stunting locations are different from the last cached locations
        if (1 == 1) {
            $emailContent = "Yth. Bapak/Ibu,\n\nKami ingin memberitahukan bahwa jumlah pasien dengan status stunting telah mencapai tingkat yang tinggi di beberapa kelurahan. Berikut adalah daftar kelurahan yang memiliki status stunting dan obesitas tinggi:\n\n" . "TESSS TOKKK" . "\n\nKami sangat mengkhawatirkan kondisi ini dan berharap dapat segera mengambil tindakan yang diperlukan untuk menanggulangi masalah stunting di wilayah ini.\n\nTerima kasih atas perhatian dan kerjasamanya.\n\nSalam,\nTim Kesehatan";
            
            // $additionalRecipients  = ['savage.kuosong@gmail.com', 'humamaziz03@gmail.com', 'justdella.24@gmail.com'];
            $uniqueEmails = array_merge(
                Pasien::distinct()->pluck('email_ortu')->toArray(), // Email orang tua
                User::distinct()->pluck('email')->toArray() // Email pengguna (admin, operator, user)
            );
            $additionalRecipients  = ['humamaziz03@gmail.com']; // Email tambahan
            $recipients = array_filter(array_merge($uniqueEmails, $additionalRecipients));

            // Mail::raw($emailContent, function ($message) use ($recipients) {
            //     $message->to($recipients)
            //         ->subject('TEST 2 - Peringatan Tingkat Stunting Tinggi di Beberapa Kelurahan');
            // });

            return response($recipients);

            // Update the last stunting email locations in cache
            // Cache::put($cacheKey, $stuntingLocations, now()->addDay()); // Cache for 1 day
        }
    }
}
