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
                'umur' => 0,
                '-3SD' => 2.0,
                '-2SD' => 2.4,
                '-1SD' => 2.8,
                'median' => 3.2,
                '1SD' => 3.7,
                '2SD' => 4.2,
                '3SD' => 4.8,
            ],
            [
                'umur' => 1,
                '-3SD' => 2.7,
                '-2SD' => 3.2,
                '-1SD' => 3.6,
                'median' => 4.2,
                '1SD' => 4.8,
                '2SD' => 5.5,
                '3SD' => 6.2,
            ],
            [
                'umur' => 2,
                '-3SD' => 3.4,
                '-2SD' => 3.9,
                '-1SD' => 4.5,
                'median' => 5.1,
                '1SD' => 5.8,
                '2SD' => 6.6,
                '3SD' => 7.5,
            ],
        ];

        // Masukkan data ke dalam tabel
        foreach ($data as $row) {
            DB::table('bb-perempuan')->insert($row);
        }
    }
}
