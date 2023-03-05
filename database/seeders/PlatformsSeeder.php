<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Platform;

class PlatformsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        $platforms = [
            1 => ['name' => 'Windows (PC)'],
            2 => ['name' => 'Linux (PC)'],
            3 => ['name' => 'MacOS (PC)'],
            4 => ['name' => 'PlayStation 1'],
            5 => ['name' => 'PlayStation 2'],
            6 => ['name' => 'PlayStation 3'],
            7 => ['name' => 'PlayStation 4'],
            8 => ['name' => 'PlayStation 5'],
            9 => ['name' => 'PlayStation Portable'],
            10 => ['name' => 'PlayStation Vita'],
            11 => ['name' => 'Xbox'],
            12 => ['name' => 'Xbox 360'],
            13 => ['name' => 'Xbox One'],
            14 => ['name' => 'Xbox One S'],
            15 => ['name' => 'Xbox One X'],
            16 => ['name' => 'Xbox Series S'],
            17 => ['name' => 'Xbox Series X'],
            18 => ['name' => 'Game Boy'],
            19 => ['name' => 'Game Boy Color'],
            20 => ['name' => 'Game Boy Advance'],
            21 => ['name' => 'Game Boy Advance SP'],
            22 => ['name' => 'Nintendo Switch']
        ];

        foreach ($platforms as $platform) {
            Platform::create([
                'name_en' => $platform['name'],
                'name_it' => $platform['name'],
                'approved' => true
            ]);
        }
    }
}
