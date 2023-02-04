<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Developer;
use File;

class DevelopersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        $json = File::get(__DIR__ . "/data/developers.json");

        $developers = json_decode($json);

        foreach ($developers as $developer) {
            Developer::create([
                "name" => $developer->name,
            ]);
        }
    }
}
