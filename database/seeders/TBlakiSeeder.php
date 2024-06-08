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
            ['UMUR' => 0, 'N3SD' => 44.2, 'N2SD' => 46.1, 'N1SD' => 48.0, 'MEDIAN' => 49.9, 'P1SD' => 51.8, 'P2SD' => 53.7, 'P3SD' => 55.6],
            ['UMUR' => 1, 'N3SD' => 48.9, 'N2SD' => 50.8, 'N1SD' => 52.8, 'MEDIAN' => 54.7, 'P1SD' => 56.7, 'P2SD' => 58.6, 'P3SD' => 60.6],
            ['UMUR' => 2, 'N3SD' => 52.4, 'N2SD' => 54.4, 'N1SD' => 56.4, 'MEDIAN' => 58.4, 'P1SD' => 60.4, 'P2SD' => 62.4, 'P3SD' => 64.4],
            ['UMUR' => 3, 'N3SD' => 55.3, 'N2SD' => 57.3, 'N1SD' => 59.4, 'MEDIAN' => 61.4, 'P1SD' => 63.5, 'P2SD' => 65.5, 'P3SD' => 67.6],
            ['UMUR' => 4, 'N3SD' => 57.6, 'N2SD' => 59.7, 'N1SD' => 61.8, 'MEDIAN' => 63.9, 'P1SD' => 66.0, 'P2SD' => 68.0, 'P3SD' => 70.1],
            ['UMUR' => 5, 'N3SD' => 59.6, 'N2SD' => 61.7, 'N1SD' => 63.8, 'MEDIAN' => 65.9, 'P1SD' => 68.0, 'P2SD' => 70.1, 'P3SD' => 72.2],
            ['UMUR' => 6, 'N3SD' => 61.2, 'N2SD' => 63.3, 'N1SD' => 65.5, 'MEDIAN' => 67.6, 'P1SD' => 69.8, 'P2SD' => 71.9, 'P3SD' => 74.0],
            ['UMUR' => 7, 'N3SD' => 62.7, 'N2SD' => 64.8, 'N1SD' => 67.0, 'MEDIAN' => 69.2, 'P1SD' => 71.3, 'P2SD' => 73.5, 'P3SD' => 75.7],
            ['UMUR' => 8, 'N3SD' => 64.0, 'N2SD' => 66.2, 'N1SD' => 68.4, 'MEDIAN' => 70.6, 'P1SD' => 72.8, 'P2SD' => 75.0, 'P3SD' => 77.2],
            ['UMUR' => 9, 'N3SD' => 65.2, 'N2SD' => 67.5, 'N1SD' => 69.7, 'MEDIAN' => 72.0, 'P1SD' => 74.2, 'P2SD' => 76.5, 'P3SD' => 78.7],
            ['UMUR' => 10, 'N3SD' => 66.4, 'N2SD' => 68.7, 'N1SD' => 71.0, 'MEDIAN' => 73.3, 'P1SD' => 75.6, 'P2SD' => 77.9, 'P3SD' => 80.1],
            ['UMUR' => 11, 'N3SD' => 67.6, 'N2SD' => 69.9, 'N1SD' => 72.2, 'MEDIAN' => 74.5, 'P1SD' => 76.9, 'P2SD' => 79.2, 'P3SD' => 81.5],
            ['UMUR' => 12, 'N3SD' => 68.6, 'N2SD' => 71.0, 'N1SD' => 73.4, 'MEDIAN' => 75.7, 'P1SD' => 78.1, 'P2SD' => 80.5, 'P3SD' => 82.9],
            ['UMUR' => 13, 'N3SD' => 69.6, 'N2SD' => 72.1, 'N1SD' => 74.5, 'MEDIAN' => 76.9, 'P1SD' => 79.3, 'P2SD' => 81.8, 'P3SD' => 84.2],
            ['UMUR' => 14, 'N3SD' => 70.6, 'N2SD' => 73.1, 'N1SD' => 75.6, 'MEDIAN' => 78.0, 'P1SD' => 80.5, 'P2SD' => 83.0, 'P3SD' => 85.5],
            ['UMUR' => 15, 'N3SD' => 71.6, 'N2SD' => 74.1, 'N1SD' => 76.6, 'MEDIAN' => 79.1, 'P1SD' => 81.7, 'P2SD' => 84.2, 'P3SD' => 86.7],
            ['UMUR' => 16, 'N3SD' => 72.5, 'N2SD' => 75.0, 'N1SD' => 77.6, 'MEDIAN' => 80.2, 'P1SD' => 82.8, 'P2SD' => 85.4, 'P3SD' => 88.0],
            ['UMUR' => 17, 'N3SD' => 73.3, 'N2SD' => 76.0, 'N1SD' => 78.6, 'MEDIAN' => 81.2, 'P1SD' => 83.9, 'P2SD' => 86.5, 'P3SD' => 89.2],
            ['UMUR' => 18, 'N3SD' => 74.2, 'N2SD' => 76.9, 'N1SD' => 79.6, 'MEDIAN' => 82.3, 'P1SD' => 85.0, 'P2SD' => 87.7, 'P3SD' => 90.4],
            ['UMUR' => 19, 'N3SD' => 75.0, 'N2SD' => 77.7, 'N1SD' => 80.5, 'MEDIAN' => 83.2, 'P1SD' => 86.0, 'P2SD' => 88.8, 'P3SD' => 91.5],
            ['UMUR' => 20, 'N3SD' => 75.8, 'N2SD' => 78.6, 'N1SD' => 81.4, 'MEDIAN' => 84.2, 'P1SD' => 87.0, 'P2SD' => 89.8, 'P3SD' => 92.6],
        ];

        // Masukkan data ke dalam tabel
        foreach ($data as $row) {
            DB::table('tb-laki-laki')->insert($row);
        }
    }
}
