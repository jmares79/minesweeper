<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GridController extends Controller
{
    public function checkCell($row, $column)
    {
        echo "checkCell";
    }

    public function markCell($row, $column)
    {
        echo "markCell";
    }
}
