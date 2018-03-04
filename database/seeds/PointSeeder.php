<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Faker::create();
        $multiplierIds = DB::table('multipliers')->pluck('id')->toArray();

        foreach (range(1, 20) as $index) {
            DB::table('points')->insert([
                'pie_value' => $fake->numberBetween(1, 20),
                'multiplier_id' => $fake->randomElement($multiplierIds)
            ]);
        }
    }
}
