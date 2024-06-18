<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BBTBlakiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id'=> 1,'TB' => 45.0, 'N3SD' => 1.9, 'N2SD' => 2.0, 'N1SD' => 2.2, 'MEDIAN' => 2.4, 'P1SD' => 2.7, 'P2SD' => 3.0, 'P3SD' => 3.3],
            ['id'=> 2,'TB' => 45.5, 'N3SD' => 1.9, 'N2SD' => 2.1, 'N1SD' => 2.3, 'MEDIAN' => 2.5, 'P1SD' => 2.8, 'P2SD' => 3.1, 'P3SD' => 3.4],
            ['id'=> 3,'TB' => 46.0, 'N3SD' => 2.0, 'N2SD' => 2.2, 'N1SD' => 2.4, 'MEDIAN' => 2.6, 'P1SD' => 2.9, 'P2SD' => 3.1, 'P3SD' => 3.5],
            ['id'=> 4,'TB' => 46.5, 'N3SD' => 2.1, 'N2SD' => 2.3, 'N1SD' => 2.5, 'MEDIAN' => 2.7, 'P1SD' => 3.0, 'P2SD' => 3.2, 'P3SD' => 3.6],
            ['id'=> 5,'TB' => 47.0, 'N3SD' => 2.1, 'N2SD' => 2.3, 'N1SD' => 2.5, 'MEDIAN' => 2.8, 'P1SD' => 3.0, 'P2SD' => 3.3, 'P3SD' => 3.7],
            ['id'=> 6,'TB' => 47.5, 'N3SD' => 2.2, 'N2SD' => 2.4, 'N1SD' => 2.6, 'MEDIAN' => 2.9, 'P1SD' => 3.1, 'P2SD' => 3.4, 'P3SD' => 3.8],
            ['id'=> 7,'TB' => 48.0, 'N3SD' => 2.3, 'N2SD' => 2.5, 'N1SD' => 2.7, 'MEDIAN' => 2.9, 'P1SD' => 3.2, 'P2SD' => 3.6, 'P3SD' => 3.9],
            ['id'=> 8,'TB' => 48.5, 'N3SD' => 2.3, 'N2SD' => 2.6, 'N1SD' => 2.8, 'MEDIAN' => 3.0, 'P1SD' => 3.3, 'P2SD' => 3.7, 'P3SD' => 4.0],
            ['id'=> 9,'TB' => 49.0, 'N3SD' => 2.4, 'N2SD' => 2.6, 'N1SD' => 2.9, 'MEDIAN' => 3.1, 'P1SD' => 3.4, 'P2SD' => 3.8, 'P3SD' => 4.2],
            ['id'=> 10,'TB' => 49.5, 'N3SD' => 2.5, 'N2SD' => 2.7, 'N1SD' => 3.0, 'MEDIAN' => 3.2, 'P1SD' => 3.5, 'P2SD' => 3.9, 'P3SD' => 4.3],
            ['id'=> 11,'TB' => 50.0, 'N3SD' => 2.6, 'N2SD' => 2.8, 'N1SD' => 3.0, 'MEDIAN' => 3.3, 'P1SD' => 3.6, 'P2SD' => 4.0, 'P3SD' => 4.4],
            ['id'=> 12,'TB' => 50.5, 'N3SD' => 2.7, 'N2SD' => 2.9, 'N1SD' => 3.1, 'MEDIAN' => 3.4, 'P1SD' => 3.8, 'P2SD' => 4.1, 'P3SD' => 4.5],
            ['id'=> 13,'TB' => 51.0, 'N3SD' => 2.7, 'N2SD' => 3.0, 'N1SD' => 3.2, 'MEDIAN' => 3.5, 'P1SD' => 3.9, 'P2SD' => 4.2, 'P3SD' => 4.7],
            ['id'=> 14,'TB' => 51.5, 'N3SD' => 2.8, 'N2SD' => 3.1, 'N1SD' => 3.3, 'MEDIAN' => 3.6, 'P1SD' => 4.0, 'P2SD' => 4.4, 'P3SD' => 4.8],
            ['id'=> 15,'TB' => 52.0, 'N3SD' => 2.9, 'N2SD' => 3.2, 'N1SD' => 3.5, 'MEDIAN' => 3.8, 'P1SD' => 4.1, 'P2SD' => 4.5, 'P3SD' => 5.0],
            ['id'=> 16,'TB' => 52.5, 'N3SD' => 3.0, 'N2SD' => 3.3, 'N1SD' => 3.6, 'MEDIAN' => 3.9, 'P1SD' => 4.2, 'P2SD' => 4.6, 'P3SD' => 5.1],
            ['id'=> 17,'TB' => 53.0, 'N3SD' => 3.1, 'N2SD' => 3.4, 'N1SD' => 3.7, 'MEDIAN' => 4.0, 'P1SD' => 4.4, 'P2SD' => 4.8, 'P3SD' => 5.3],
            ['id'=> 18,'TB' => 53.5, 'N3SD' => 3.2, 'N2SD' => 3.5, 'N1SD' => 3.8, 'MEDIAN' => 4.1, 'P1SD' => 4.5, 'P2SD' => 4.9, 'P3SD' => 5.4],
            ['id'=> 19,'TB' => 54.0, 'N3SD' => 3.3, 'N2SD' => 3.6, 'N1SD' => 3.9, 'MEDIAN' => 4.3, 'P1SD' => 4.7, 'P2SD' => 5.1, 'P3SD' => 5.6],
            ['id'=> 20,'TB' => 54.5, 'N3SD' => 3.4, 'N2SD' => 3.7, 'N1SD' => 4.0, 'MEDIAN' => 4.4, 'P1SD' => 4.8, 'P2SD' => 5.3, 'P3SD' => 5.8],
        ];

        // Masukkan data ke dalam tabel
        foreach ($data as $row) {
            DB::table('bbtb-laki-laki')->insert($row);
        }
    }
}
