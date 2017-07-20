<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function grid()
    {
        return $this->hasOne('App\Grid');
    }

    public function savings()
    {
        return $this->hasMany('App\Saving');
    }
}
