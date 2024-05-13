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
                'umur' => 0,
                '-3SD' => 44.2,
                '-2SD' => 46.1,
                '-1SD' => 48.0,
                'median' => 49.9,
                '1SD' => 51.8,
                '2SD' => 53.7,
                '3SD' => 55.6,
            ],
            [
                'umur' => 1,
                '-3SD' => 48.9,
                '-2SD' => 50.8,
                '-1SD' => 52.8,
                'median' => 54.7,
                '1SD' => 56.7,
                '2SD' => 58.6,
                '3SD' => 60.6,
            ],
            [
                'umur' => 2,
                '-3SD' => 52.4,
                '-2SD' => 54.4,
                '-1SD' => 56.4,
                'median' => 58.4,
                '1SD' => 60.4,
                '2SD' => 62.4,
                '3SD' => 64.4,
            ],
        ];

        // Masukkan data ke dalam tabel
        foreach ($data as $row) {
            DB::table('tb-laki-laki')->insert($row);
        }
    }
}
