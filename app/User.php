<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'type_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function casts()
    {
        return $this->hasMany(Cast::class);
    }

    public function accountType()
    {
        return DB::table('user_types')->where('id', $this->type_id)->first()->type;
    }

    public function avatar()
    {
        return "https://www.gravatar.com/avatar/" . md5($this->email) .'?s=80&d=retro';
    }

    public function isAdmin()
    {
        return $this->accountType() === "admin";
    }
}
