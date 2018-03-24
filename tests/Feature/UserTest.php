<?php

namespace Tests\Feature;

use App\User;
use Tests\APITestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends APITestCase
{
    use RefreshDatabase;

    public function testFetchSingleUser()
    {
        $user = factory(User::class)->create();

        $response = $this->get('/api/v1/users/' . $user->id);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment([
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
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
                'name' => $user->name,
                'username' => $user->username,
                'account_type' => $user->accountType()
            ]);
        }
    }

    public function testCreateSingleUser()
    {
        $user = factory(User::class)->make();

        $response = $this->json('POST', '/api/v1/users', [
            "email" => $user->email,
            "username" => $user->username,
            "password" => $user->password,
            "name" => $user->name
        ]);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'username',
                    'avatar',
                    'account_type'
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email
        ]);
    }

    public function testCreateMultipleUsers()
    {
        $users = factory(User::class, 3)->make();

        $response = $this->json('POST', '/api/v1/users', [
            [
                "email" => $users[0]->email,
                "username" => $users[0]->username,
                "password" => $users[0]->password,
                "name" => $users[0]->name
            ],
            [

                "email" => $users[1]->email,
                "username" => $users[1]->username,
                "password" => $users[1]->password,
                "name" => $users[1]->name
            ],
            [
                "email" => $users[2]->email,
                "username" => $users[2]->username,
                "password" => $users[2]->password,
                "name" => $users[2]->name
            ]
        ]);

        $response->assertStatus(Response::HTTP_OK);

        foreach ($users as $user) {
            $this->assertDatabaseHas('users', [
                'name' => $user->name,
                'email' => $user->email,
                'username' => $user->username
            ]);
        }
    }

    public function testUpdateUser()
    {
        $user = factory(User::class)->create();
        $newName = "Pinocchio";

        $response = $this->json('PATCH', '/api/v1/users/' . $user->id, [
            "name" => $newName
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $newName
        ]);
    }

    public function testDeleteUser()
    {
        $user = factory(User::class)->create();

        $response = $this->delete('api/v1/users/' . $user->id);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }
}
