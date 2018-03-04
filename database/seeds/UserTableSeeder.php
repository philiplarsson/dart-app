<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Faker::create();

        $userTypeIds = DB::table('user_types')->pluck('id')->toArray();

        foreach (range(1, 5) as $index)
        {
            \App\User::create([
                'name' => $fake->name,
                'username' => $fake->userName,
                'email' => $fake->email,
                'password' => $fake->password,
                'type_id' => $fake->randomElement($userTypeIds)
            ]);
        }
    }
}
