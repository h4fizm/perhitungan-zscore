<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BBlakiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['UMUR' => 0, 'N3SD' => 2.1, 'N2SD' => 2.5, 'N1SD' => 2.9, 'MEDIAN' => 3.3, 'P1SD' => 3.9, 'P2SD' => 4.4, 'P3SD' => 5.0],
            ['UMUR' => 1, 'N3SD' => 2.9, 'N2SD' => 3.4, 'N1SD' => 3.9, 'MEDIAN' => 4.5, 'P1SD' => 5.1, 'P2SD' => 5.8, 'P3SD' => 6.6],
            ['UMUR' => 2, 'N3SD' => 3.8, 'N2SD' => 4.3, 'N1SD' => 4.9, 'MEDIAN' => 5.6, 'P1SD' => 6.3, 'P2SD' => 7.1, 'P3SD' => 8.0],
        ];

        // Masukkan data ke dalam tabel
        foreach ($data as $row) {
            DB::table('bb-laki-laki')->insert($row);
        }
    }
}
