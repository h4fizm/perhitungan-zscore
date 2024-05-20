<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BBperempuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'UMUR' => 0,
                'N3SD' => 2.0,
                'N2SD' => 2.4,
                'N1SD' => 2.8,
                'MEDIAN' => 3.2,
                'P1SD' => 3.7,
                'P2SD' => 4.2,
                'P3SD' => 4.8,
            ],
            [
                'UMUR' => 1,
                'N3SD' => 2.7,
                'N2SD' => 3.2,
                'N1SD' => 3.6,
                'MEDIAN' => 4.2,
                'P1SD' => 4.8,
                'P2SD' => 5.5,
                'P3SD' => 6.2,
            ],
            [
                'UMUR' => 2,
                'N3SD' => 3.4,
                'N2SD' => 3.9,
                'N1SD' => 4.5,
                'MEDIAN' => 5.1,
                'P1SD' => 5.8,
                'P2SD' => 6.6,
                'P3SD' => 7.5,
            ],
        ];

        // Masukkan data ke dalam tabel
        foreach ($data as $row) {
            DB::table('bb-perempuan')->insert($row);
        }
    }
}
