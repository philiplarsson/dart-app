<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('user_types')->truncate();
        DB::table('users')->truncate();
        DB::table('game_types')->truncate();
        DB::table('games')->truncate();
        DB::table('multipliers')->truncate();
        DB::table('points')->truncate();
        DB::table('throws')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->call(UserTypeSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(GameTypeSeeder::class);
        $this->call(GameSeeder::class);
        $this->call(MultiplierSeeder::class);
        $this->call(PointSeeder::class);
        $this->call(ThrowSeeder::class);
    }
}
