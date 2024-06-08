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
            ['UMUR' => 0, 'N3SD' => 2.0, 'N2SD' => 2.4, 'N1SD' => 2.8, 'MEDIAN' => 3.2, 'P1SD' => 3.7, 'P2SD' => 4.2, 'P3SD' => 4.8],
            ['UMUR' => 1, 'N3SD' => 2.7, 'N2SD' => 3.2, 'N1SD' => 3.6, 'MEDIAN' => 4.2, 'P1SD' => 4.8, 'P2SD' => 5.5, 'P3SD' => 6.2],
            ['UMUR' => 2, 'N3SD' => 3.4, 'N2SD' => 3.9, 'N1SD' => 4.5, 'MEDIAN' => 5.1, 'P1SD' => 5.8, 'P2SD' => 6.6, 'P3SD' => 7.5],
            ['UMUR' => 3, 'N3SD' => 4.0, 'N2SD' => 4.5, 'N1SD' => 5.2, 'MEDIAN' => 5.8, 'P1SD' => 6.6, 'P2SD' => 7.5, 'P3SD' => 8.5],
            ['UMUR' => 4, 'N3SD' => 4.4, 'N2SD' => 5.0, 'N1SD' => 5.7, 'MEDIAN' => 6.4, 'P1SD' => 7.3, 'P2SD' => 8.2, 'P3SD' => 9.3],
            ['UMUR' => 5, 'N3SD' => 4.8, 'N2SD' => 5.4, 'N1SD' => 6.1, 'MEDIAN' => 6.9, 'P1SD' => 7.8, 'P2SD' => 8.8, 'P3SD' => 10.0],
            ['UMUR' => 6, 'N3SD' => 5.1, 'N2SD' => 5.7, 'N1SD' => 6.5, 'MEDIAN' => 7.3, 'P1SD' => 8.2, 'P2SD' => 9.3, 'P3SD' => 10.6],
            ['UMUR' => 7, 'N3SD' => 5.3, 'N2SD' => 6.0, 'N1SD' => 6.8, 'MEDIAN' => 7.6, 'P1SD' => 8.6, 'P2SD' => 9.8, 'P3SD' => 11.1],
            ['UMUR' => 8, 'N3SD' => 5.6, 'N2SD' => 6.3, 'N1SD' => 7.0, 'MEDIAN' => 7.9, 'P1SD' => 9.0, 'P2SD' => 10.2, 'P3SD' => 11.6],
            ['UMUR' => 9, 'N3SD' => 5.8, 'N2SD' => 6.5, 'N1SD' => 7.3, 'MEDIAN' => 8.2, 'P1SD' => 9.3, 'P2SD' => 10.5, 'P3SD' => 12.0],
            ['UMUR' => 10, 'N3SD' => 5.9, 'N2SD' => 6.7, 'N1SD' => 7.5, 'MEDIAN' => 8.5, 'P1SD' => 9.6, 'P2SD' => 10.9, 'P3SD' => 12.4],
            ['UMUR' => 11, 'N3SD' => 6.1, 'N2SD' => 6.9, 'N1SD' => 7.7, 'MEDIAN' => 8.7, 'P1SD' => 9.9, 'P2SD' => 11.2, 'P3SD' => 12.8],
            ['UMUR' => 12, 'N3SD' => 6.3, 'N2SD' => 7.0, 'N1SD' => 7.9, 'MEDIAN' => 8.9, 'P1SD' => 10.1, 'P2SD' => 11.5, 'P3SD' => 13.1],
            ['UMUR' => 13, 'N3SD' => 6.4, 'N2SD' => 7.2, 'N1SD' => 8.1, 'MEDIAN' => 9.2, 'P1SD' => 10.4, 'P2SD' => 11.8, 'P3SD' => 13.5],
            ['UMUR' => 14, 'N3SD' => 6.6, 'N2SD' => 7.4, 'N1SD' => 8.3, 'MEDIAN' => 9.4, 'P1SD' => 10.6, 'P2SD' => 12.1, 'P3SD' => 13.8],
            ['UMUR' => 15, 'N3SD' => 6.7, 'N2SD' => 7.6, 'N1SD' => 8.5, 'MEDIAN' => 9.6, 'P1SD' => 10.9, 'P2SD' => 12.4, 'P3SD' => 14.1],
            ['UMUR' => 16, 'N3SD' => 6.9, 'N2SD' => 7.7, 'N1SD' => 8.7, 'MEDIAN' => 9.8, 'P1SD' => 11.1, 'P2SD' => 12.6, 'P3SD' => 14.5],
            ['UMUR' => 17, 'N3SD' => 7.0, 'N2SD' => 7.9, 'N1SD' => 8.9, 'MEDIAN' => 10.0, 'P1SD' => 11.4, 'P2SD' => 12.9, 'P3SD' => 14.8],
            ['UMUR' => 18, 'N3SD' => 7.2, 'N2SD' => 8.1, 'N1SD' => 9.1, 'MEDIAN' => 10.2, 'P1SD' => 11.6, 'P2SD' => 13.2, 'P3SD' => 15.1],
            ['UMUR' => 19, 'N3SD' => 7.3, 'N2SD' => 8.2, 'N1SD' => 9.2, 'MEDIAN' => 10.4, 'P1SD' => 11.8, 'P2SD' => 13.5, 'P3SD' => 15.4],
            ['UMUR' => 20, 'N3SD' => 7.5, 'N2SD' => 8.4, 'N1SD' => 9.4, 'MEDIAN' => 10.6, 'P1SD' => 12.1, 'P2SD' => 13.7, 'P3SD' => 15.7],
        ];

        // Masukkan data ke dalam tabel
        foreach ($data as $row) {
            DB::table('bb-perempuan')->insert($row);
        }
    }
}
