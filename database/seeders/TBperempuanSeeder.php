<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TBperempuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'UMUR' => 0,
                'N3SD' => 43.6,
                'N2SD' => 45.4,
                'N1SD' => 47.3,
                'MEDIAN' => 49.1,
                'P1SD' => 51.0,
                'P2SD' => 52.9,
                'P3SD' => 54.7,
            ],
            [
                'UMUR' => 1,
                'N3SD' => 47.8,
                'N2SD' => 49.8,
                'N1SD' => 51.7,
                'MEDIAN' => 53.7,
                'P1SD' => 55.6,
                'P2SD' => 57.6,
                'P3SD' => 59.5,
            ],
            [
                'UMUR' => 2,
                'N3SD' => 51.0,
                'N2SD' => 53.0,
                'N1SD' => 55.0,
                'MEDIAN' => 57.1,
                'P1SD' => 59.1,
                'P2SD' => 61.1,
                'P3SD' => 63.2,
            ],
        ];

        // Masukkan data ke dalam tabel
        foreach ($data as $row) {
            DB::table('tb-perempuan')->insert($row);
        }
    }
}
