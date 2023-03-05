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
            9 => ['name' => 'PSP'],
            10 => ['name' => 'Xbox'],
            11 => ['name' => 'Xbox 360'],
            12 => ['name' => 'Xbox One'],
            13 => ['name' => 'GameBoy'],
            14 => ['name' => 'GameBoy Advanced'],
            15 => ['name' => 'Nintendo Switch']
        ];

        foreach ($platforms as $platform) {
            Platform::create([
                'name_en' => $platform['name'],
                'name_it' => $platform['name']
            ]);
        }
    }
}
