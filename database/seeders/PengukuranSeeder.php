<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengukuranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_pasien' => 3,
                'umur' => 2, // Umur langsung ditentukan di sini
                'tanggal_pengukuran' => '2024-05-01',
                'berat_badan' => 50.5,
                'tinggi_badan' => 165.0,
                'status_gizi' => 'stunting',
                'status_tinggi' => 'normal',
            ],
            [
                'id_pasien' => 3,
                'umur' => 2, // Umur langsung ditentukan di sini
                'tanggal_pengukuran' => '2024-05-05',
                'berat_badan' => 48.0,
                'tinggi_badan' => 160.5,
                'status_gizi' => 'normal',
                'status_tinggi' => 'pendek',
            ],
            [
                'id_pasien' => 2,
                'umur' => 2, // Umur langsung ditentukan di sini
                'tanggal_pengukuran' => '2024-05-10',
                'berat_badan' => 55.2,
                'tinggi_badan' => 170.0,
                'status_gizi' => 'obesitas',
                'status_tinggi' => 'pendek',
            ],
        ];

        // Masukkan data ke dalam tabel
        foreach ($data as $row) {
            DB::table('pengukuran')->insert($row);
        }
    }
}
