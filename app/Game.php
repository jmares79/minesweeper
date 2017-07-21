<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function grid()
    {
        return $this->hasOne(Grid::class);
    }

    public function savings()
    {
        return $this->hasMany(Saving::class);
    }
}
