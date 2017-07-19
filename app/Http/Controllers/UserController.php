<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getAll()
    {
        return "Get All Users";
    }

    public function save()
    {
        return "save";
    }
}
