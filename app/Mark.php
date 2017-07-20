<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    public function grid()
    {
        $this->belongsTo('App\Grid');
    }
}
