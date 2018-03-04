<?php

namespace App;

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
}
