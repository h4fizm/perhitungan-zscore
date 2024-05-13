<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Tambahkan data lokasi Surabaya
        Location::create([
            'name_location' => 'Surabaya',
            'latitude' => -7.2575,
            'longitude' => 112.7521,
            'radius' => 31068.31, // Sesuaikan nilai radius dengan tipe data double
            'value' => 55,
        ]);

        // Tambahkan data lokasi Malang
        Location::create([
            'name_location' => 'Malang',
            'latitude' => -7.9666,
            'longitude' => 112.6326,
            'radius' => 31068.31, // Sesuaikan nilai radius dengan tipe data double
            'value' => 20,
        ]);

        // Tambahkan data lokasi Sidoarjo
        Location::create([
            'name_location' => 'Sidoarjo',
            'latitude' => -7.4478,
            'longitude' => 112.7181,
            'radius' => 31068.31, // Sesuaikan nilai radius dengan tipe data double
            'value' => 5,
        ]);
    }
}
