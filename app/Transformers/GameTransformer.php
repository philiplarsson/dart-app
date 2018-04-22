<?php

namespace App\Transformers;

use App\Game;
use App\Transformers\GameTypeTransformer;
use League\Fractal\TransformerAbstract;

class GameTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'gametype'
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Game $game)
    {
        return [
            'id'               => $game->id,
            'created_at'       => $game->created_at->toDateTimeString(),
            'created_at_human' => $game->created_at->diffForHumans(),
        ];
    }

    public function includeGameType(Game $game)
    {
        return $this->item($game->gameType, new GameTypeTransformer);
    }
}
