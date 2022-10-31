<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Film;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            FilmSeeder::class,
            HallSeeder::class,
            SeanceSeeder::class,
            TicketSeeder::class,
            UserSeeder::class,
        ]);
    }
}
