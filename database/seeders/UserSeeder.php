<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role' => 'Admin',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'location_id' => null, // location_id dikosongkan untuk Admin
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Guest',
            'email' => 'guest@guest.com',
            'role' => 'Guest',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'location_id' => null, // location_id dikosongkan untuk Guest
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Operator',
            'email' => 'operator@operator.com',
            'role' => 'Operator',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'id_location' => 1, // Pastikan ID lokasi sudah ada di tabel locations
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
