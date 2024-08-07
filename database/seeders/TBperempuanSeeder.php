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
            ['UMUR' => 21, 'N3SD' => 74.5, 'N2SD' => 77.5, 'N1SD' => 80.6, 'MEDIAN' => 83.7, 'P1SD' => 86.7, 'P2SD' => 89.8, 'P3SD' => 92.9],
            ['UMUR' => 22, 'N3SD' => 75.2, 'N2SD' => 78.4, 'N1SD' => 81.5, 'MEDIAN' => 84.6, 'P1SD' => 87.7, 'P2SD' => 90.8, 'P3SD' => 94.0],
            ['UMUR' => 23, 'N3SD' => 76.0, 'N2SD' => 79.2, 'N1SD' => 82.3, 'MEDIAN' => 85.5, 'P1SD' => 88.7, 'P2SD' => 91.9, 'P3SD' => 95.0],
            ['UMUR' => 24, 'N3SD' => 76.7, 'N2SD' => 80.0, 'N1SD' => 83.2, 'MEDIAN' => 86.4, 'P1SD' => 89.6, 'P2SD' => 92.9, 'P3SD' => 96.1],
            ['UMUR' => 25, 'N3SD' => 76.8, 'N2SD' => 80.0, 'N1SD' => 83.3, 'MEDIAN' => 86.6, 'P1SD' => 89.9, 'P2SD' => 93.1, 'P3SD' => 96.4],
            ['UMUR' => 26, 'N3SD' => 77.5, 'N2SD' => 80.8, 'N1SD' => 84.1, 'MEDIAN' => 87.4, 'P1SD' => 90.8, 'P2SD' => 94.1, 'P3SD' => 97.4],
            ['UMUR' => 27, 'N3SD' => 78.1, 'N2SD' => 81.5, 'N1SD' => 84.9, 'MEDIAN' => 88.3, 'P1SD' => 91.7, 'P2SD' => 95.0, 'P3SD' => 98.4],
            ['UMUR' => 28, 'N3SD' => 78.8, 'N2SD' => 82.2, 'N1SD' => 85.7, 'MEDIAN' => 89.1, 'P1SD' => 92.5, 'P2SD' => 96.0, 'P3SD' => 99.4],
            ['UMUR' => 29, 'N3SD' => 79.5, 'N2SD' => 82.9, 'N1SD' => 86.4, 'MEDIAN' => 89.9, 'P1SD' => 93.4, 'P2SD' => 96.9, 'P3SD' => 100.3],
            ['UMUR' => 30, 'N3SD' => 80.1, 'N2SD' => 83.6, 'N1SD' => 87.1, 'MEDIAN' => 90.7, 'P1SD' => 94.2, 'P2SD' => 97.7, 'P3SD' => 101.3],
            ['UMUR' => 31, 'N3SD' => 80.7, 'N2SD' => 84.3, 'N1SD' => 87.9, 'MEDIAN' => 91.4, 'P1SD' => 95.0, 'P2SD' => 98.6, 'P3SD' => 102.2],
            ['UMUR' => 32, 'N3SD' => 81.3, 'N2SD' => 84.9, 'N1SD' => 88.6, 'MEDIAN' => 92.2, 'P1SD' => 95.8, 'P2SD' => 99.4, 'P3SD' => 103.1],
            ['UMUR' => 33, 'N3SD' => 81.9, 'N2SD' => 85.6, 'N1SD' => 89.3, 'MEDIAN' => 92.9, 'P1SD' => 96.6, 'P2SD' => 100.3, 'P3SD' => 103.9],
            ['UMUR' => 34, 'N3SD' => 82.5, 'N2SD' => 86.2, 'N1SD' => 89.9, 'MEDIAN' => 93.6, 'P1SD' => 97.4, 'P2SD' => 101.1, 'P3SD' => 104.8],
            ['UMUR' => 35, 'N3SD' => 83.1, 'N2SD' => 86.8, 'N1SD' => 90.6, 'MEDIAN' => 94.4, 'P1SD' => 98.1, 'P2SD' => 101.9, 'P3SD' => 105.6],
            ['UMUR' => 36, 'N3SD' => 83.6, 'N2SD' => 87.4, 'N1SD' => 91.2, 'MEDIAN' => 95.1, 'P1SD' => 98.9, 'P2SD' => 102.7, 'P3SD' => 106.5],
            ['UMUR' => 37, 'N3SD' => 84.2, 'N2SD' => 88.0, 'N1SD' => 91.9, 'MEDIAN' => 95.7, 'P1SD' => 99.6, 'P2SD' => 103.4, 'P3SD' => 107.3],
            ['UMUR' => 38, 'N3SD' => 84.7, 'N2SD' => 88.6, 'N1SD' => 92.5, 'MEDIAN' => 96.4, 'P1SD' => 100.3, 'P2SD' => 104.2, 'P3SD' => 108.1],
            ['UMUR' => 39, 'N3SD' => 85.3, 'N2SD' => 89.2, 'N1SD' => 93.1, 'MEDIAN' => 97.1, 'P1SD' => 101.0, 'P2SD' => 105.0, 'P3SD' => 108.9],
            ['UMUR' => 40, 'N3SD' => 85.8, 'N2SD' => 89.8, 'N1SD' => 93.8, 'MEDIAN' => 97.7, 'P1SD' => 101.7, 'P2SD' => 105.7, 'P3SD' => 109.7],
            ['UMUR' => 41, 'N3SD' => 86.3, 'N2SD' => 90.4, 'N1SD' => 94.4, 'MEDIAN' => 98.4, 'P1SD' => 102.4, 'P2SD' => 106.4, 'P3SD' => 110.5],
            ['UMUR' => 42, 'N3SD' => 86.8, 'N2SD' => 90.9, 'N1SD' => 95.0, 'MEDIAN' => 99.0, 'P1SD' => 103.1, 'P2SD' => 107.2, 'P3SD' => 111.2],
            ['UMUR' => 43, 'N3SD' => 87.4, 'N2SD' => 91.5, 'N1SD' => 95.6, 'MEDIAN' => 99.7, 'P1SD' => 103.8, 'P2SD' => 107.9, 'P3SD' => 112.0],
            ['UMUR' => 44, 'N3SD' => 87.9, 'N2SD' => 92.0, 'N1SD' => 96.2, 'MEDIAN' => 100.3, 'P1SD' => 104.5, 'P2SD' => 108.6, 'P3SD' => 112.7],
            ['UMUR' => 45, 'N3SD' => 88.4, 'N2SD' => 92.5, 'N1SD' => 96.7, 'MEDIAN' => 100.9, 'P1SD' => 105.1, 'P2SD' => 109.3, 'P3SD' => 113.5],
            ['UMUR' => 46, 'N3SD' => 88.9, 'N2SD' => 93.1, 'N1SD' => 97.3, 'MEDIAN' => 101.5, 'P1SD' => 105.8, 'P2SD' => 110.0, 'P3SD' => 114.2],
            ['UMUR' => 47, 'N3SD' => 89.3, 'N2SD' => 93.6, 'N1SD' => 97.9, 'MEDIAN' => 102.1, 'P1SD' => 106.4, 'P2SD' => 110.7, 'P3SD' => 114.9],
            ['UMUR' => 48, 'N3SD' => 89.8, 'N2SD' => 94.1, 'N1SD' => 98.4, 'MEDIAN' => 102.7, 'P1SD' => 107.0, 'P2SD' => 111.3, 'P3SD' => 115.7],
            ['UMUR' => 49, 'N3SD' => 90.3, 'N2SD' => 94.6, 'N1SD' => 99.0, 'MEDIAN' => 103.3, 'P1SD' => 107.7, 'P2SD' => 112.0, 'P3SD' => 116.4],
            ['UMUR' => 50, 'N3SD' => 90.7, 'N2SD' => 95.1, 'N1SD' => 99.5, 'MEDIAN' => 103.9, 'P1SD' => 108.3, 'P2SD' => 112.7, 'P3SD' => 117.1],
            ['UMUR' => 51, 'N3SD' => 91.2, 'N2SD' => 95.6, 'N1SD' => 100.1, 'MEDIAN' => 104.5, 'P1SD' => 108.9, 'P2SD' => 113.3, 'P3SD' => 117.7],
            ['UMUR' => 52, 'N3SD' => 91.7, 'N2SD' => 96.1, 'N1SD' => 100.6, 'MEDIAN' => 105.0, 'P1SD' => 109.5, 'P2SD' => 114.0, 'P3SD' => 118.4],
            ['UMUR' => 53, 'N3SD' => 92.1, 'N2SD' => 96.6, 'N1SD' => 101.1, 'MEDIAN' => 105.6, 'P1SD' => 110.1, 'P2SD' => 114.6, 'P3SD' => 119.1],
            ['UMUR' => 54, 'N3SD' => 92.6, 'N2SD' => 97.1, 'N1SD' => 101.6, 'MEDIAN' => 106.2, 'P1SD' => 110.7, 'P2SD' => 115.2, 'P3SD' => 119.8],
            ['UMUR' => 55, 'N3SD' => 93.0, 'N2SD' => 97.6, 'N1SD' => 102.2, 'MEDIAN' => 106.7, 'P1SD' => 111.3, 'P2SD' => 115.9, 'P3SD' => 120.4],
            ['UMUR' => 56, 'N3SD' => 93.4, 'N2SD' => 98.1, 'N1SD' => 102.7, 'MEDIAN' => 107.3, 'P1SD' => 111.9, 'P2SD' => 116.5, 'P3SD' => 121.1],
            ['UMUR' => 57, 'N3SD' => 93.9, 'N2SD' => 98.5, 'N1SD' => 103.2, 'MEDIAN' => 107.8, 'P1SD' => 112.5, 'P2SD' => 117.1, 'P3SD' => 121.8],
            ['UMUR' => 58, 'N3SD' => 94.3, 'N2SD' => 99.0, 'N1SD' => 103.7, 'MEDIAN' => 108.4, 'P1SD' => 113.0, 'P2SD' => 117.7, 'P3SD' => 122.4],
            ['UMUR' => 59, 'N3SD' => 94.7, 'N2SD' => 99.5, 'N1SD' => 104.2, 'MEDIAN' => 108.9, 'P1SD' => 113.6, 'P2SD' => 118.3, 'P3SD' => 123.1],
            ['UMUR' => 60, 'N3SD' => 95.2, 'N2SD' => 99.9, 'N1SD' => 104.7, 'MEDIAN' => 109.4, 'P1SD' => 114.2, 'P2SD' => 118.9, 'P3SD' => 123.7],
        ];

        // Masukkan data ke dalam tabel
        foreach ($data as $row) {
            DB::table('tb-perempuan')->insert($row);
        }
    }
}
