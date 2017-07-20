<?php

namespace App\Interfaces;

/**
 *  Interface for a concrete file reader
 */
interface GameCreatorInterface
{
    public function createGame($rows, $columns, $mines);
}
