<?php

use Illuminate\Database\Seeder;

class TestingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserTypeSeeder::class,
            MultiplierSeeder::class,
            PointSeeder::class,
            // UserTableSeeder::class,
            // GameTypeSeeder::class,
            // GameSeeder::class,
            // ThrowSeeder::class,
        ]);
    }
}