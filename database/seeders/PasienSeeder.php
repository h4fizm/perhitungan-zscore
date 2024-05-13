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
                'tanggal_lahir' => '1990-05-20',
                'jenis_kelamin' => 'laki-laki', // Jenis kelamin laki-laki
                'id_location' => 1, // Sesuaikan dengan ID lokasi yang ingin Anda masukkan
                'alamat' => 'Jl. Ahmad Yani No. 123', // Tambahkan alamat
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nik' => '3578072009020002',
                'nama' => 'Jane Doe',
                'tanggal_lahir' => '1995-10-15',
                'jenis_kelamin' => 'perempuan', // Jenis kelamin perempuan
                'id_location' => 2, // Sesuaikan dengan ID lokasi yang ingin Anda masukkan
                'alamat' => 'Jl. Merdeka No. 456', // Tambahkan alamat
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Tambahkan data lainnya sesuai kebutuhan
        ];

        DB::table('pasien')->insert($data);
    }
}
