<?php

namespace App;

use App\Traits\Orderable;
use App\Scopes\LatestFirstScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    use Orderable;

    // Throw is a bad model name since it's a protected keyword in PHP.
    protected $table = 'throws';

    protected $fillable = [
        'user_id', 'game_id', 'point_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LatestFirstScope);
    }

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
