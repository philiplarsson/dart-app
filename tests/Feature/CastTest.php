<?php

namespace Tests\Feature;

use App\Cast;
use App\Game;
use App\User;
use Illuminate\Http\Response;
use Tests\APITestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CastTest extends APITestCase
{
    use RefreshDatabase;

    public function testFetchSingleCast()
    {
        $this->signIn();
        $cast = factory(Cast::class)->create();

        $response = $this->get('/api/v1/throws/' . $cast->id);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "data" => [
                    "id",
                    "pie_value",
                    "multiplier",
                    "created_at",
                    "created_at_human",
                    "user",
                    "game"
                ]
            ]);
    }

    public function testCreateSingleCast()
    {
        $this->signIn();
        $cast = factory(Cast::class)->create();

        $response = $this->json('POST', '/api/v1/throws', [
            "user_id" => $cast->user->id,
            "game_id" => $cast->game->id,
            "pie_value" => 50,
            "multiplier" => 1
        ]);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "data" => [
                    "id",
                    "pie_value",
                    "multiplier",
                    "created_at",
                    "created_at_human",
                ]
        ]);

        $this->assertDatabaseHas('throws', [
            "user_id" => $cast->user->id,
            "game_id" => $cast->game->id,
        ]);
    }

    public function testUpdateCastAsAdmin()
    {
        $this->signInAsAdmin();
        $cast = factory(Cast::class)->create();

        $game = factory(Game::class)->create();

        $response = $this->json('PATCH', '/api/v1/throws/' . $cast->id, [
            "game_id" => $game->id
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "data" => [
                    "id",
                    "pie_value",
                    "multiplier",
                    "created_at",
                    "created_at_human",
            ]
        ]);

        $this->assertDatabaseHas('throws', [
            "id" => $cast->id,
            "user_id" => $cast->user->id,
            "game_id" => $game->id
        ]);
    }

    public function testUpdateCastAsUser()
    {
        $this->signIn();
        $cast = factory(Cast::class)->create();

        $game = factory(Game::class)->create();

        $response = $this->json('PATCH', '/api/v1/throws/' . $cast->id, [
            "game_id" => $game->id
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testUpdateMultipleCastsAsAdmin()
    {
        $this->signInAsAdmin();
        $casts = factory(Cast::class, 2)->create();
        $user = factory(User::class)->create();

        $response = $this->json('PATCH', '/api/v1/throws', [
                [
                    'id' => $casts[0]->id,
                    'user_id' => $user->id
                ],
                [
                    'id' => $casts[1]->id,
                    'user_id' => $user->id
                ]
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                    "data" => [
                    [
                        "id",
                        "pie_value",
                        "multiplier",
                        "created_at",
                        "created_at_human",
                    ],
                    [
                        "id",
                        "pie_value",
                        "multiplier",
                        "created_at",
                        "created_at_human",
                    ]
                    ]
            ]
            );


        $this->assertDatabaseHas('throws', [
            'id' => $casts[0]->id,
            'user_id' => $user->id
        ]);

        $this->assertDatabaseHas('throws', [
            'id' => $casts[1]->id,
            'user_id' => $user->id
        ]);
    }

    public function testDeleteCastAsUser()
    {
        $this->signIn();
        $cast = factory(Cast::class)->create();

        $response = $this->delete('/api/v1/throws/' . $cast->id);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testDeleteCastAsAdmin()
    {
        $this->signInAsAdmin();
        $cast = factory(Cast::class)->create();

        $response = $this->delete('/api/v1/throws/' . $cast->id);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertDatabaseMissing('throws', [
           'id' => $cast->id
        ]);
    }
}
