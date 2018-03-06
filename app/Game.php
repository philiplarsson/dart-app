<?php

namespace App;

use App\Traits\Orderable;
use App\Scopes\LatestFirstScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Game extends Model
{
    use Orderable;

    protected $fillable = [
        'game_type_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LatestFirstScope);
    }

    public function gameType()
    {
        return $this->belongsTo(GameType::class);
    }

    public function casts()
    {
        return $this->hasMany(Cast::class);
    }
}
