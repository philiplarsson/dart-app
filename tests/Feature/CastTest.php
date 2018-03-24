<?php

namespace Tests\Feature;

use App\Cast;
use App\Game;
use Illuminate\Http\Response;
use Tests\APITestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CastTest extends APITestCase
{
    use RefreshDatabase;

    public function testFetchSingleCast()
    {
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
            "id" => $cast->id,
            "user_id" => $cast->user->id,
            "game_id" => $cast->game->id
        ]);
    }

    public function testUpdateCast()
    {
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

    public function testDeleteCast()
    {
        $cast = factory(Cast::class)->create();

        $response = $this->delete('/api/v1/throws/' . $cast->id);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertDatabaseMissing('throws', [
           'id' => $cast->id
        ]);
    }
}
