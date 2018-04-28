<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id'               => $user->id,
            'name'             => $user->name,
            'username'         => $user->username,
            'email'            => $user->email,
            'avatar'           => $user->avatar(),
            'account_type'     => $user->accountType(),
            'created_at'       => $user->created_at->toDateTimeString(),
            'created_at_human' => $user->created_at->diffForHumans(),
        ];
    }
}
