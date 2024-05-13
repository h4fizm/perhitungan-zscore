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
            ['umur' => 0, '-3SD' => 2.1, '-2SD' => 2.5, '-1SD' => 2.9, 'median' => 3.3, '1SD' => 3.9, '2SD' => 4.4, '3SD' => 5.0],
            ['umur' => 1, '-3SD' => 2.9, '-2SD' => 3.4, '-1SD' => 3.9, 'median' => 4.5, '1SD' => 5.1, '2SD' => 5.8, '3SD' => 6.6],
            ['umur' => 2, '-3SD' => 3.8, '-2SD' => 4.3, '-1SD' => 4.9, 'median' => 5.6, '1SD' => 6.3, '2SD' => 7.1, '3SD' => 8.0],
        ];

        // Masukkan data ke dalam tabel
        foreach ($data as $row) {
            DB::table('bb-laki-laki')->insert($row);
        }
    }
}
