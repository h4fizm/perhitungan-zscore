<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            BBlakiSeeder::class,
            BBperempuanSeeder::class,
            BBTBlakiSeeder::class,
            BBTBperempuanSeeder::class,
            LocationSeeder::class,
            TBlakiSeeder::class,
            TBperempuanSeeder::class,
            UserSeeder::class,
            PasienSeeder::class
        ]);
    }
}
