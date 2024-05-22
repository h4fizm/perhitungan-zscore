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
            ['UMUR' => 3, 'N3SD' => 4.4, 'N2SD' => 5.0, 'N1SD' => 5.7, 'MEDIAN' => 6.4, 'P1SD' => 7.2, 'P2SD' => 8.0, 'P3SD' => 9.0],
            ['UMUR' => 4, 'N3SD' => 4.9, 'N2SD' => 5.6, 'N1SD' => 6.2, 'MEDIAN' => 7.0, 'P1SD' => 7.8, 'P2SD' => 8.7, 'P3SD' => 9.7],
            ['UMUR' => 5, 'N3SD' => 5.3, 'N2SD' => 6.0, 'N1SD' => 6.7, 'MEDIAN' => 7.5, 'P1SD' => 8.4, 'P2SD' => 9.3, 'P3SD' => 10.4],
            ['UMUR' => 6, 'N3SD' => 5.7, 'N2SD' => 6.4, 'N1SD' => 7.1, 'MEDIAN' => 7.9, 'P1SD' => 8.8, 'P2SD' => 9.8, 'P3SD' => 10.9],
            ['UMUR' => 7, 'N3SD' => 5.9, 'N2SD' => 6.7, 'N1SD' => 7.4, 'MEDIAN' => 8.3, 'P1SD' => 9.2, 'P2SD' => 10.3, 'P3SD' => 11.4],
            ['UMUR' => 8, 'N3SD' => 6.2, 'N2SD' => 6.9, 'N1SD' => 7.7, 'MEDIAN' => 8.6, 'P1SD' => 9.6, 'P2SD' => 10.7, 'P3SD' => 11.9],
            ['UMUR' => 9, 'N3SD' => 6.4, 'N2SD' => 7.1, 'N1SD' => 8.0, 'MEDIAN' => 8.9, 'P1SD' => 9.9, 'P2SD' => 11.0, 'P3SD' => 12.3],
            ['UMUR' => 10, 'N3SD' => 6.6, 'N2SD' => 7.4, 'N1SD' => 8.2, 'MEDIAN' => 9.2, 'P1SD' => 10.2, 'P2SD' => 11.4, 'P3SD' => 12.7],
            ['UMUR' => 11, 'N3SD' => 6.8, 'N2SD' => 7.6, 'N1SD' => 8.4, 'MEDIAN' => 9.4, 'P1SD' => 10.5, 'P2SD' => 11.7, 'P3SD' => 13.0],
            ['UMUR' => 12, 'N3SD' => 6.9, 'N2SD' => 7.7, 'N1SD' => 8.6, 'MEDIAN' => 9.6, 'P1SD' => 10.8, 'P2SD' => 12.0, 'P3SD' => 13.3],
            ['UMUR' => 13, 'N3SD' => 7.1, 'N2SD' => 7.9, 'N1SD' => 8.8, 'MEDIAN' => 9.9, 'P1SD' => 11.0, 'P2SD' => 12.3, 'P3SD' => 13.7],
            ['UMUR' => 14, 'N3SD' => 7.2, 'N2SD' => 8.1, 'N1SD' => 9.0, 'MEDIAN' => 10.1, 'P1SD' => 11.3, 'P2SD' => 12.6, 'P3SD' => 14.0],
            ['UMUR' => 15, 'N3SD' => 7.4, 'N2SD' => 8.3, 'N1SD' => 9.2, 'MEDIAN' => 10.3, 'P1SD' => 11.5, 'P2SD' => 12.8, 'P3SD' => 14.3],
            ['UMUR' => 16, 'N3SD' => 7.5, 'N2SD' => 8.4, 'N1SD' => 9.4, 'MEDIAN' => 10.5, 'P1SD' => 11.7, 'P2SD' => 13.1, 'P3SD' => 14.6],
            ['UMUR' => 17, 'N3SD' => 7.7, 'N2SD' => 8.6, 'N1SD' => 9.6, 'MEDIAN' => 10.7, 'P1SD' => 12.0, 'P2SD' => 13.4, 'P3SD' => 14.9],
            ['UMUR' => 18, 'N3SD' => 7.8, 'N2SD' => 8.8, 'N1SD' => 9.8, 'MEDIAN' => 10.9, 'P1SD' => 12.2, 'P2SD' => 13.7, 'P3SD' => 15.3],
            ['UMUR' => 19, 'N3SD' => 8.0, 'N2SD' => 8.9, 'N1SD' => 10.0, 'MEDIAN' => 11.1, 'P1SD' => 12.5, 'P2SD' => 13.9, 'P3SD' => 15.6],
            ['UMUR' => 20, 'N3SD' => 8.1, 'N2SD' => 9.1, 'N1SD' => 10.1, 'MEDIAN' => 11.3, 'P1SD' => 12.7, 'P2SD' => 14.2, 'P3SD' => 15.9],
        ];

        // Masukkan data ke dalam tabel
        foreach ($data as $row) {
            DB::table('bb-laki-laki')->insert($row);
        }
    }
}
