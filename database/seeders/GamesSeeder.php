<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\Publisher;
use App\Models\Developer;
use Illuminate\Support\Facades\DB;
use File;

class GamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        // Game::factory(100)->create();

        // Game::truncate();

        // NOTE: The value '[Unknown]' is used hard-coded for those game whose publishers or developers are not known. The ID to assign to those Foreign Keys will be automatically retrieved.

        $json = File::get(__DIR__ . "/data/WindowsGames.json");

        $games = json_decode($json);

        foreach ($games as $game) {
            $developer = $publisher = null;

            if (empty($game->Dev)) {
                $gameDeveloper = '[Unknown]';
            } else {
                $gameDeveloper = $game->Dev;
            }

            $developer = DB::table('developers')->where('name', $gameDeveloper)->first();

            if (empty($game->Publisher)) {
                $gamePublisher = '[Unknown]';
            } else {
                $gamePublisher = $game->Publisher;
            }

            $publisher = DB::table('publishers')->where('name', $gamePublisher)->first();

            Game::create([
                "title" => $game->Game,
                "platform_id" => 1,
                "developer_id" => $developer->id,
                "publisher_id" => $publisher->id,
                "year" => $game->Year
            ]);
        }
    }
}
