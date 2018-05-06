<?php

namespace Tests;

use App\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

abstract class APITestCase extends TestCase
{

    /**
     * @var Faker
     */
    protected $fake;
    protected $adminTypeId;
    protected $userTypeId;

    public function setUp()
    {
        parent::setUp();
        $this->seed('TestingDatabaseSeeder');
        $this->fake = Faker::create();
        $this->adminTypeId = DB::table('user_types')->where('type', 'admin')->first()->id;
        $this->userTypeId = DB::table('user_types')->where('type', 'user')->first()->id;
    }

    protected function signIn($user = null)
    {
        $user = $user ?: factory(User::class)->create(['type_id' => $this->userTypeId]);

        $this->actingAs($user);

        return $this;
    }

    protected function signInAsAdmin()
    {
        return $this->signIn(factory(User::class)->create(['type_id' => $this->adminTypeId]));
    }

}
