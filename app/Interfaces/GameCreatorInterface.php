<?php

namespace App\Interfaces;

interface GameCreatorInterface
{
    public function createGame($rows, $columns, $mines);
    public function setMinesOnGrid($grid, $rows, $columns, $mines);
}
