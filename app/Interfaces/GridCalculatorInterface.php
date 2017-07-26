<?php

namespace App\Interfaces;

/**
 *  Interface for a concrete grid calculator algorithm
 */
interface GridCalculatorInterface
{
    public function revealAdjacentCells($row, $column);
}
