<?php

namespace App\Transformers;

use App\GameType;
use League\Fractal\TransformerAbstract;

class GameTypeTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(GameType $gameType)
    {
        return [
            'id'               => $gameType->id,
            'name'             => $gameType->name,
            'description'      => $gameType->description,
            'created_at'       => $gameType->created_at->toDateTimeString(),
            'created_at_human' => $gameType->created_at->diffForHumans(),
        ];
    }
}
