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
            'id' => $gameType->id,
            'name' => $gameType->name,
            'description' => $gameType->description,
        ];
    }
}
