<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class GameTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Faker::create();

        \App\GameType::create([
            'name' => "20 to 15",
            'description' => $fake->sentence,
        ]);

        \App\GameType::create([
            'name' => "201",
            'description' => $fake->sentence,
        ]);
    }
}
