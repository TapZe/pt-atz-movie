<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            PriceSeeder::class,
            CinemaSeeder::class,
            AuditoriumSeeder::class,
            GenreSeeder::class,
            MovieSeeder::class,
            SeatSeeder::class,
            PromoSeeder::class,
            MovieScheduleSeeder::class,
        ]);
    }
}
