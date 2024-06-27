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
        // Tambahkan data lokasi Baratajaya
        Location::create([
            'name_location' => 'Kelurahan Baratajaya',
            'value' => 3,
        ]);
        // Tambahkan data lokasi Pucang Sewu
        Location::create([
            'name_location' => 'Kelurahan Pucang Sewu',
            'value' => 2,
        ]);
        // Tambahkan data lokasi Kertajaya
        Location::create([
            'name_location' => 'Kelurahan Kertajaya',
            'value' => 1,
        ]);
        // Tambahkan data lokasi Gubeng
        Location::create([
            'name_location' => 'Kelurahan Gubeng',
            'value' => 1,
        ]);
        // Tambahkan data lokasi Airlangga
        Location::create([
            'name_location' => 'Kelurahan Airlangga',
            'value' => 3,
        ]);
        // Tambahkan data lokasi Mojo
        Location::create([
            'name_location' => 'Kelurahan Mojo',
            'value' => 2,
        ]);
    }
}
