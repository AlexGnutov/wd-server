<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tickets')->insert([
            'date' => date_format(date_create('now'), 'Y-m-d'),
            'seanceId' => 1,
            'seats' => json_encode([
                ['row' => 4, 'col' => 4, 'type' => 's'],
                ['row' => 5, 'col' => 5, 'type' => 's'],
            ]),
        ]);

        DB::table('tickets')->insert([
            'date' => date_format(date_create('now'), 'Y-m-d'),
            'seanceId' => 1,
            'seats' => json_encode([
                ['row' => 4, 'col' => 4, 'type' => 's'],
            ]),
        ]);

        DB::table('tickets')->insert([
            'date' => date_format(date_create('now'), 'Y-m-d'),
            'seanceId' => 1,
            'seats' => json_encode([
                ['row' => 3, 'col' => 3, 'type' => 's'],
            ]),
        ]);

        DB::table('tickets')->insert([
            'date' => date_format(date_create('now'), 'Y-m-d'),
            'seanceId' => 2,
            'seats' => json_encode([
                ['row' => 3, 'col' => 3, 'type' => 's'],
            ]),
        ]);

        DB::table('tickets')->insert([
            'date' => date_format(date_create('now'), 'Y-m-d'),
            'seanceId' => 2,
            'seats' => json_encode([
                ['row' => 3, 'col' => 4, 'type' => 's'],
            ]),
        ]);
    }
}
