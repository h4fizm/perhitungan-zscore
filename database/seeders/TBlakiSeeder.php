<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TBlakiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'UMUR' => 0,
                'N3SD' => 44.2,
                'N2SD' => 46.1,
                'N1SD' => 48.0,
                'MEDIAN' => 49.9,
                'P1SD' => 51.8,
                'P2SD' => 53.7,
                'P3SD' => 55.6,
            ],
            [
                'UMUR' => 1,
                'N3SD' => 48.9,
                'N2SD' => 50.8,
                'N1SD' => 52.8,
                'MEDIAN' => 54.7,
                'P1SD' => 56.7,
                'P2SD' => 58.6,
                'P3SD' => 60.6,
            ],
            [
                'UMUR' => 2,
                'N3SD' => 52.4,
                'N2SD' => 54.4,
                'N1SD' => 56.4,
                'MEDIAN' => 58.4,
                'P1SD' => 60.4,
                'P2SD' => 62.4,
                'P3SD' => 64.4,
            ],
        ];

        // Masukkan data ke dalam tabel
        foreach ($data as $row) {
            DB::table('tb-laki-laki')->insert($row);
        }
    }
}
