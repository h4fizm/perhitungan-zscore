<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Contoh pengisian data
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role' => 'Admin', // Ubah peran ke 'super-admin'
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Menggunakan bcrypt() untuk mengenkripsi kata sandi
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Guest',
            'email' => 'guest@guest.com',
            'role' => 'Guest', // Ubah peran ke 'super-admin'
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Menggunakan bcrypt() untuk mengenkripsi kata sandi
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Jika Anda ingin membuat lebih banyak contoh data, tambahkan insert statement sesuai kebutuhan
    }
}
