<?php

use Illuminate\Database\Seeder;

class MultiplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('multipliers')->insert([
            'value' => 1
        ]);

        DB::table('multipliers')->insert([
            'value' => 2
        ]);

        DB::table('multipliers')->insert([
            'value' => 3
        ]);
    }
}
