<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grid extends Model
{
    public function game()
    {
        return $this->belongsTo('App\Game');
    }

    public function marks()
    {
        return $this->hasMany('App\Mark');
    }
}
