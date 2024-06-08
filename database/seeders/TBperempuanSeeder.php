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
            ['UMUR' => 0, 'N3SD' => 43.6, 'N2SD' => 45.4, 'N1SD' => 47.3, 'MEDIAN' => 49.1, 'P1SD' => 51.0, 'P2SD' => 52.9, 'P3SD' => 54.7],
            ['UMUR' => 1, 'N3SD' => 47.8, 'N2SD' => 49.8, 'N1SD' => 51.7, 'MEDIAN' => 53.7, 'P1SD' => 55.6, 'P2SD' => 57.6, 'P3SD' => 59.5],
            ['UMUR' => 2, 'N3SD' => 51.0, 'N2SD' => 53.0, 'N1SD' => 55.0, 'MEDIAN' => 57.1, 'P1SD' => 59.1, 'P2SD' => 61.1, 'P3SD' => 63.2],
            ['UMUR' => 3, 'N3SD' => 53.5, 'N2SD' => 55.6, 'N1SD' => 57.7, 'MEDIAN' => 59.8, 'P1SD' => 61.9, 'P2SD' => 64.0, 'P3SD' => 66.1],
            ['UMUR' => 4, 'N3SD' => 55.6, 'N2SD' => 57.8, 'N1SD' => 59.9, 'MEDIAN' => 62.1, 'P1SD' => 64.3, 'P2SD' => 66.4, 'P3SD' => 68.6],
            ['UMUR' => 5, 'N3SD' => 57.4, 'N2SD' => 59.6, 'N1SD' => 61.8, 'MEDIAN' => 64.0, 'P1SD' => 66.2, 'P2SD' => 68.5, 'P3SD' => 70.7],
            ['UMUR' => 6, 'N3SD' => 58.9, 'N2SD' => 61.2, 'N1SD' => 63.5, 'MEDIAN' => 65.7, 'P1SD' => 68.0, 'P2SD' => 70.3, 'P3SD' => 72.5],
            ['UMUR' => 7, 'N3SD' => 60.3, 'N2SD' => 62.7, 'N1SD' => 65.0, 'MEDIAN' => 67.3, 'P1SD' => 69.6, 'P2SD' => 71.9, 'P3SD' => 74.2],
            ['UMUR' => 8, 'N3SD' => 61.7, 'N2SD' => 64.0, 'N1SD' => 66.4, 'MEDIAN' => 68.7, 'P1SD' => 71.1, 'P2SD' => 73.5, 'P3SD' => 75.8],
            ['UMUR' => 9, 'N3SD' => 62.9, 'N2SD' => 65.3, 'N1SD' => 67.7, 'MEDIAN' => 70.1, 'P1SD' => 72.6, 'P2SD' => 75.0, 'P3SD' => 77.4],
            ['UMUR' => 10, 'N3SD' => 64.1, 'N2SD' => 66.5, 'N1SD' => 69.0, 'MEDIAN' => 71.5, 'P1SD' => 73.9, 'P2SD' => 76.4, 'P3SD' => 78.9],
            ['UMUR' => 11, 'N3SD' => 65.2, 'N2SD' => 67.7, 'N1SD' => 70.3, 'MEDIAN' => 72.8, 'P1SD' => 75.3, 'P2SD' => 77.8, 'P3SD' => 80.3],
            ['UMUR' => 12, 'N3SD' => 66.3, 'N2SD' => 68.9, 'N1SD' => 71.4, 'MEDIAN' => 74.0, 'P1SD' => 76.6, 'P2SD' => 79.2, 'P3SD' => 81.7],
            ['UMUR' => 13, 'N3SD' => 67.3, 'N2SD' => 70.0, 'N1SD' => 72.6, 'MEDIAN' => 75.2, 'P1SD' => 77.8, 'P2SD' => 80.5, 'P3SD' => 83.1],
            ['UMUR' => 14, 'N3SD' => 68.3, 'N2SD' => 71.0, 'N1SD' => 73.7, 'MEDIAN' => 76.4, 'P1SD' => 79.1, 'P2SD' => 81.7, 'P3SD' => 84.4],
            ['UMUR' => 15, 'N3SD' => 69.3, 'N2SD' => 72.0, 'N1SD' => 74.8, 'MEDIAN' => 77.5, 'P1SD' => 80.2, 'P2SD' => 83.0, 'P3SD' => 85.7],
            ['UMUR' => 16, 'N3SD' => 70.2, 'N2SD' => 73.0, 'N1SD' => 75.8, 'MEDIAN' => 78.6, 'P1SD' => 81.4, 'P2SD' => 84.2, 'P3SD' => 87.0],
            ['UMUR' => 17, 'N3SD' => 71.1, 'N2SD' => 74.0, 'N1SD' => 76.8, 'MEDIAN' => 79.7, 'P1SD' => 82.5, 'P2SD' => 85.4, 'P3SD' => 88.2],
            ['UMUR' => 18, 'N3SD' => 72.0, 'N2SD' => 74.9, 'N1SD' => 77.8, 'MEDIAN' => 80.7, 'P1SD' => 83.6, 'P2SD' => 86.5, 'P3SD' => 89.4],
            ['UMUR' => 19, 'N3SD' => 72.8, 'N2SD' => 75.8, 'N1SD' => 78.8, 'MEDIAN' => 81.7, 'P1SD' => 84.7, 'P2SD' => 87.6, 'P3SD' => 90.6],
            ['UMUR' => 20, 'N3SD' => 73.7, 'N2SD' => 76.7, 'N1SD' => 79.7, 'MEDIAN' => 82.7, 'P1SD' => 85.7, 'P2SD' => 88.7, 'P3SD' => 91.7],
        ];

        // Masukkan data ke dalam tabel
        foreach ($data as $row) {
            DB::table('tb-perempuan')->insert($row);
        }
    }
}
