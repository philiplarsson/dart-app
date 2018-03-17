<?php

namespace Tests;

abstract class APITestCase extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->seed('TestingDatabaseSeeder');
    }
}
