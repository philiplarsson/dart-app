<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    // Throw is a bad model name since it's a protected keyword in PHP.
    protected $table = 'throws';

    protected $fillable = [
        'user_id', 'game_id', 'point_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function point()
    {
        return DB::table('points')->where('id', $this->point_id)->first();
    }

    public function multiplier()
    {
        $point = $this->point();
        return DB::table('multipliers')->where('id', $point->multiplier_id)->first();
    }
}
