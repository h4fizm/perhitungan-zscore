<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nik' => '3578072009020001',
                'nama' => 'John Doe',
                'tanggal_lahir' => '2023-12-01',
                'jenis_kelamin' => 'laki-laki',
                'id_location' => 1,
                'alamat' => 'Jl. Ahmad Yani No. 123',
                'tanggal_pengukuran' => '2023-01-01',
                'umur' => 5,
                'berat_badan' => 0,
                'tinggi_badan' => 0,
                'status_gizi' => 'normal',      //'stunting', 'normal', 'obesitas'
                'status_tinggi' => 'normal',    //'pendek', 'normal', 'tinggi'
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nik' => '3578072009020002',
                'nama' => 'Jane Doe',
                'tanggal_lahir' => '2024-02-15',
                'jenis_kelamin' => 'perempuan',
                'id_location' => 3,
                'alamat' => 'Jl. Merdeka No. 456',
                'tanggal_pengukuran' => '2023-01-02',
                'umur' => 3,
                'berat_badan' => 0,
                'tinggi_badan' => 0,
                'status_gizi' => 'normal',      //'stunting', 'normal', 'obesitas'
                'status_tinggi' => 'normal',    //'pendek', 'normal', 'tinggi'
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nik' => '3578072009020003',
                'nama' => 'Alice Johnson',
                'tanggal_lahir' => '2023-12-22',
                'jenis_kelamin' => 'perempuan',
                'id_location' => 3,
                'alamat' => 'Jl. Kemerdekaan No. 789',
                'tanggal_pengukuran' => '2023-01-03',
                'umur' => 5,
                'berat_badan' => 0,
                'tinggi_badan' => 0,
                'status_gizi' => 'normal',      //'stunting', 'normal', 'obesitas'
                'status_tinggi' => 'normal',    //'pendek', 'normal', 'tinggi'
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nik' => '3578072009020004',
                'nama' => 'Bob Marley',
                'tanggal_lahir' => '2024-03-19',
                'jenis_kelamin' => 'laki-laki',
                'id_location' => 3,
                'alamat' => 'Jl. Diponegoro No. 321',
                'tanggal_pengukuran' => '2023-01-04',
                'umur' => 3,
                'berat_badan' => 0,
                'tinggi_badan' => 0,
                'status_gizi' => 'normal',  //'stunting', 'normal', 'obesitas'
                'status_tinggi' => 'normal', //'pendek', 'normal', 'tinggi'
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nik' => '3578072009020005',
                'nama' => 'Clara Smith',
                'tanggal_lahir' => '2024-03-30',
                'jenis_kelamin' => 'perempuan',
                'id_location' => 2,
                'alamat' => 'Jl. Sudirman No. 234',
                'tanggal_pengukuran' => '2023-01-05',
                'umur' => 3,
                'berat_badan' => 0,
                'tinggi_badan' => 0,
                'status_gizi' => 'normal',      //'stunting', 'normal', 'obesitas'
                'status_tinggi' => 'normal',    //'pendek', 'normal', 'tinggi'
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        DB::table('pasien')->insert($data);
    }
}
