<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Faker::create();

        $gameTypesIds = DB::table('game_types')->pluck('id')->toArray();

        foreach(range(1, 20) as $index)
        {
            \App\Game::create([
                'started_at' => $fake->dateTime(),
                'gametype_id' => $fake->randomElement($gameTypesIds)
            ]);
        }

    }
}
