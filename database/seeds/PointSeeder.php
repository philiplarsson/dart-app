<?php

use Illuminate\Database\Seeder;

class PointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $multiplierIds = DB::table('multipliers')->pluck('id')->toArray();

        foreach (range(1, 20) as $index) {
            foreach ($multiplierIds as $multiplier) {
                DB::table('points')->insert([
                    'pie_value' => $index,
                    'multiplier_id' => $multiplier
                ]);
            }
        }

        // Add Bullseye
        DB::table('points')->insert([
            'pie_value' => 25,
            'multiplier_id' => DB::table('multipliers')->where('value', 1)->value('id')
        ]);
        DB::table('points')->insert([
            'pie_value' => 50,
            'multiplier_id' => DB::table('multipliers')->where('value', 1)->value('id')
        ]);
    }
}
