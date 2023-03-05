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
                $developer = '[Unknown]';
            } else {
                $developer = trim($game->Dev);
                $commaPosition = null;

                if (($commaPosition = strpos($developer, ',')) !== false) {
                    $developer = substr($developer, 0, $commaPosition - 1);
                }
            }

            $developer = DB::table('developers')->where('name_en', $developer)->first();

            if (empty($game->Publisher)) {
                $gamePublisher = '[Unknown]';
            } else {
                $gamePublisher = trim($game->Publisher);

                $commaPosition = null;

                if (($commaPosition = strpos($publisher, ',')) !== false) {
                    $publisher = substr($publisher, 0, $commaPosition - 1);
                }
            }

            $publisher = DB::table('publishers')->where('name_en', $gamePublisher)->first();

            Game::create([
                "title_en" => trim($game->Game),
                "title_it" => trim($game->Game),
                "platform_id" => 1,
                "developer_id" => $developer->id ?? 0,
                "publisher_id" => $publisher->id ?? 0,
                "year" => intval($game->Year ?? 0),
                'link' => trim($game->GameLink ?? ''),
                'approved' => true
            ]);
        }
    }
}
