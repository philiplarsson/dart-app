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

        DB::table('game_types')->insert([
            'name' => "20 to 15",
            'description' => $fake->sentence,
        ]);

        DB::table('game_types')->insert([
            'name' => "201",
            'description' => $fake->sentence,
        ]);
    }
}
