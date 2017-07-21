<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grid extends Model
{
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
}
