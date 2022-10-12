<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('seances')->insert([
            'startTime' => 780,
            'filmId' => 1,
            'hallId' => 1,
        ]);

        DB::table('seances')->insert([
            'startTime' => 1000,
            'filmId' => 2,
            'hallId' => 1,
        ]);

        DB::table('seances')->insert([
            'startTime' => 600,
            'filmId' => 1,
            'hallId' => 2,
        ]);

        DB::table('seances')->insert([
            'startTime' => 800,
            'filmId' => 1,
            'hallId' => 2,
        ]);
    }
}
