<?php

use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_types')->insert([
            'type' => 'user'
        ]);

        DB::table('user_types')->insert([
            'type' => 'admin'
        ]);
    }
}
