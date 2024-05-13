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
                'umur' => 0,
                '-3SD' => 43.6,
                '-2SD' => 45.4,
                '-1SD' => 47.3,
                'median' => 49.1,
                '1SD' => 51.0,
                '2SD' => 52.9,
                '3SD' => 54.7,
            ],
            [
                'umur' => 1,
                '-3SD' => 47.8,
                '-2SD' => 49.8,
                '-1SD' => 51.7,
                'median' => 53.7,
                '1SD' => 55.6,
                '2SD' => 57.6,
                '3SD' => 59.5,
            ],
            [
                'umur' => 2,
                '-3SD' => 51.0,
                '-2SD' => 53.0,
                '-1SD' => 55.0,
                'median' => 57.1,
                '1SD' => 59.1,
                '2SD' => 61.1,
                '3SD' => 63.2,
            ],
        ];

        // Masukkan data ke dalam tabel
        foreach ($data as $row) {
            DB::table('tb-perempuan')->insert($row);
        }
    }
}
