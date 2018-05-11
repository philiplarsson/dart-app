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
        $this->signIn();
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
        $this->signIn();
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

    public function testUpdateSingleGameType()
    {
        $this->signIn();
        $gameType = factory(GameType::class)->create();

        $newName = $this->fake->name;
        $newDescription = $this->fake->sentence;

        $response = $this->json('PATCH', '/api/v1/gametypes/' . $gameType->id, [
                "name"        => $newName,
                "description" => $newDescription
        ]);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "data" => [
                    "id",
                    "name",
                    "description",
            ]
        ]);

        $this->assertDatabaseHas('game_types', [
            'id'          => $gameType->id,
            'name'        => $newName,
            'description' => $newDescription
        ]);
    }

    public function testUpdateMultipleGameTypes()
    {
        $this->signIn();
        $gameTypes = factory(GameType::class, 2)->create();

        $newNames[] = $this->fake->name;
        $newNames[] = $this->fake->name;

        $newDescriptions[] = $this->fake->sentence;
        $newDescriptions[] = $this->fake->sentence;

        $response = $this->json('PATCH', '/api/v1/gametypes', [
                [
                    "id"          => $gameTypes[0]->id,
                    "name"        => $newNames[0],
                    "description" => $newDescriptions[0]
                ],
                [
                    "id"          => $gameTypes[1]->id,
                    "name"        => $newNames[1],
                    "description" => $newDescriptions[1]
                ]
        ]);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "data" => [
                    [
                        "id",
                        "name",
                        "description",
                    ],
                    [
                        "id",
                        "name",
                        "description",
                    ]
            ]
        ]);

        $this->assertDatabaseHas('game_types', [
            'id'          => $gameTypes[0]->id,
            'name'        => $newNames[0],
            'description' => $newDescriptions[0]
        ]);

        $this->assertDatabaseHas('game_types', [
            'id'          => $gameTypes[1]->id,
            'name'        => $newNames[1],
            'description' => $newDescriptions[1]
        ]);
    }
}
