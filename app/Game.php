<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'started_at', 'game_type_id'
    ];

    public function gameType()
    {
        return $this->belongsTo(GameType::class);
    }

    public function casts()
    {
        return $this->hasMany(Cast::class);
    }
}
