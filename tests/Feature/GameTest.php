<?php

namespace Tests\Feature;

use App\Game;
use App\GameType;
use Tests\APITestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GameTest extends APITestCase
{
    use RefreshDatabase;

    public function testFetchSingleGame()
    {
        $this->signIn();
        $game = factory(Game::class)->create();

        $response = $this->get('/api/v1/games/' . $game->id);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                    "data" => [
                        "id",
                        "created_at",
                        "created_at_human",
                        "gametype" => [
                            "data" => [
                                "id",
                                "name",
                                "description"
                            ]
                        ]
                    ]
            ]);
    }

    public function testFetchMultipleGames()
    {
        $this->signIn();
        $games = factory(Game::class, 2)->create();

        $response = $this->get('/api/v1/games')
            ->assertStatus(Response::HTTP_OK);
    }

    public function testCreateSingleGame()
    {
        $this->signIn();
        $game = factory(Game::class)->make();

        $response = $this->json('POST', '/api/v1/games', [
            'game_type_id' => $game->game_type_id
        ]);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                    "data" => [
                        "id",
                        "created_at",
                        "created_at_human",
                        "gametype" => [
                            "data" => [
                                "id",
                                "name",
                                "description"
                            ]
                        ]
                    ]
            ]);
    }

    public function testUpdateSingleGame()
    {
        $this->signIn();
        $gameType = factory(GameType::class)->create();
        $game = factory(Game::class)->create();

        $response = $this->json('PATCH', '/api/v1/games/' . $game->id, [
            'game_type_id' => $gameType->id
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testUpdateMultipleGames()
    {
        $this->signIn();
        $games = factory(Game::class, 2)->create();
        $gameTypes = factory(GameType::class, 2)->create();

        $response = $this->json('PATCH', '/api/v1/games', [
            [
                'id'           => $games[0]->id,
                'game_type_id' => $gameTypes[0]->id
            ],
            [
                'id'           => $games[1]->id,
                'game_type_id' => $gameTypes[1]->id
            ]
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testDeleteSingleGameAsUser()
    {
        $this->signIn();
        $game = factory(Game::class)->create();

        $response = $this->json('DELETE', '/api/v1/games/' . $game->id);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testDeleteSingleGameAsAdmin()
    {
        $this->signInAsAdmin();
        $game = factory(Game::class)->create();

        $response = $this->json('DELETE', '/api/v1/games/' . $game->id);

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('games', [
            'id' => $game->id
        ]);
    }
}
