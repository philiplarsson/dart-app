<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class ThrowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Faker::create();

        $userIds = DB::table('users')->pluck('id')->toArray();
        $gameIds = DB::table('games')->pluck('id')->toArray();
        $pointIds = DB::table('points')->pluck('id')->toArray();

        foreach (range(1, 30) as $index) {
            DB::table('throws')->insert([
                'user_id' => $fake->randomElement($userIds),
                'game_id' => $fake->randomElement($gameIds),
                'point_id' => $fake->randomElement($pointIds)
            ]);
        }
    }
}
