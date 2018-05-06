<?php

namespace App\Transformers;

use App\User;
use Illuminate\Support\Facades\Auth;
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
        $userArray = [
            'id'               => $user->id,
            'username'         => $user->username,
            'avatar'           => $user->avatar(),
            'created_at'       => $user->created_at->toDateTimeString(),
            'created_at_human' => $user->created_at->diffForHumans(),
        ];

        if (Auth::user()->isAdmin()) {
            $userArray = array_merge($userArray, [
                'name'             => $user->name,
                'email'            => $user->email,
                'account_type'     => $user->accountType(),
            ]);
        }

        return $userArray;
    }
}
