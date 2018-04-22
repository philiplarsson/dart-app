<?php

namespace App\Transformers;

use App\Cast;
use League\Fractal\TransformerAbstract;

class CastTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'user',
        'game'
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Cast $cast)
    {
        return [
            'id'               => $cast->id,
            'pie_value'        => $cast->point()->pie_value,
            'multiplier'       => $cast->multiplier()->value,
            'created_at'       => $cast->created_at->toDateTimeString(),
            'created_at_human' => $cast->created_at->diffForHumans(),
        ];
    }

    public function includeUser(Cast $cast)
    {
        return $this->item($cast->user, new UserTransformer);
    }

    public function includeGame(Cast $cast)
    {
        return $this->item($cast->game, new GameTransformer);
    }
}
