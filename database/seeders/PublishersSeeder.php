<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Publisher;
use File;

class PublishersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        $json = File::get(__DIR__ . "/data/publishers.json");

        $publishers = json_decode($json);

        foreach ($publishers as $publisher) {
            Publisher::create([
                "name" => $publisher->name,
            ]);
        }
    }
}
