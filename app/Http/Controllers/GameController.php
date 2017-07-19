<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    public function newgame($rows, $columns, $mines)
    {
        return "newgame";
    }

    public function save()
    {
        return "save";
    }

    public function resume($id)
    {
        return "resume";
    }
}
