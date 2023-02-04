<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \Database\Seeders\GamesSeeder;
use \Database\Seeders\GamesPlatformsSeeder;
use \Database\Seeders\ReviewsSeeder;
use \Database\Seeders\UsersSeeder;
use \Database\Seeders\PublishersSeeder;
use \Database\Seeders\DevelopersSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // GamesPlatformsSeeder::run();
        GamesSeeder::run();
        // UsersSeeder::run();
        // ReviewsSeeder::run();
        // PublishersSeeder::run();
        // DevelopersSeeder::run();
    }
}
