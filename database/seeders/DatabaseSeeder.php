<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\KandidatSeeder;
use Database\Seeders\KegiatanSeeder;
use Database\Seeders\ProgramStudiSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(ProgramStudiSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(KegiatanSeeder::class);
        $this->call(KandidatSeeder::class);
    }
}
