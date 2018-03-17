<?php

namespace Tests;

use Faker\Factory as Faker;

abstract class APITestCase extends TestCase
{

    /**
     * @var Faker
     */
    protected $fake;

    public function setUp()
    {
        parent::setUp();
        $this->seed('TestingDatabaseSeeder');
        $this->fake = Faker::create();
    }
}
