<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('films')->insert([
            'title' => 'Звёздные войны XXIII: Атака клонированных клонов',
            'synopsis' => 'Две сотни лет назад малороссийские хутора разоряла шайка нехристей-ляхов во главе с могущественным колдуном.',
            'duration' => 130,
            'origin' => 'CША',
            'imageText' => 'Звёздные войны постер',
            'imageFilename' => 'poster1.jpg'
        ]);

        DB::table('films')->insert([
            'title' => 'Альфа',
            'synopsis' => '20 тысяч лет назад Земля была холодным и неуютным местом, в котором смерть подстерегала человека на каждом шагу.',
            'duration' => 96,
            'origin' => 'Франция',
            'imageText' => 'Альфа постер',
            'imageFilename' => 'poster2.jpg'
        ]);

        DB::table('films')->insert([
            'title' => 'Звёздные войны XXIII: Атака клонированных клонов',
            'synopsis' => 'Две сотни лет назад малороссийские хутора разоряла шайка нехристей-ляхов во главе с могущественным колдуном.',
            'duration' => 130,
            'origin' => 'CША',
            'imageText' => 'Звёздные войны постер',
            'imageFilename' => 'poster1.jpg'
        ]);
    }
}
