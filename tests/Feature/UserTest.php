<?php

namespace Tests\Feature;

use App\User;
use Tests\APITestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends APITestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testFetchSingleUser()
    {
        $user = factory(User::class)->create();

        $response = $this->get('/api/v1/users');

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment([
                'id'           => $user->id,
                'name'         => $user->name,
                'username'     => $user->username,
                'account_type' => $user->accountType()
            ]);
    }

    public function testFetchMultipleUsers()
    {
        $users = factory(User::class, 5)->create();

        $response = $this->get('/api/v1/users');

        $response->assertStatus(Response::HTTP_OK);

        foreach ($users as $user) {
            $response->assertJsonFragment([
                'id' => $user->id,
                'name'         => $user->name,
                'username'     => $user->username,
                'account_type' => $user->accountType()
            ]);
        }
    }
}
