<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameType extends Model
{
    protected $fillable = [
        'name', 'description'
    ];
}
