<?php

namespace Tests\Feature;

use App\GameType;
use Tests\APITestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GameTypeTest extends APITestCase
{
    use RefreshDatabase;

    public function testCreateSingleGameType()
    {
        $gameType = factory(GameType::class)->make();

        $response = $this->json('POST', '/api/v1/gametypes', [
            "name" => $gameType->name,
            "description" => $gameType->description
        ]);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "data" => [
                    "id",
                    "name",
                    "description"
                ]
            ]);

        $this->assertDatabaseHas('game_types', [
            'name' => $gameType->name,
            'description' => $gameType->description
        ]);
    }

    public function testCreateMultipleGameTypes()
    {
        $gameTypes = factory(GameType::class, 2)->make();

        $response = $this->json('POST', '/api/v1/gametypes', [
            [
                "name"        => $gameTypes[0]->name,
                "description" => $gameTypes[0]->description
            ],
            [
                "name"        => $gameTypes[1]->name,
                "description" => $gameTypes[1]->description
            ]
        ]);

        $response
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('game_types', [
                "name"        => $gameTypes[0]->name,
                "description" => $gameTypes[0]->description
        ]);

        $this->assertDatabaseHas('game_types', [
                "name"        => $gameTypes[1]->name,
                "description" => $gameTypes[1]->description
        ]);
    }
}
