<?php

namespace App\Service\Grid;

use App\Interfaces\GridCalculatorInterface;
use App\Grid;
use App\Mark;

class GridService implements GridCalculatorInterface
{
    protected $grid;
    protected $cellToCheck = array();
    protected $revealedCells = array();
    protected static $adjacentMines = 0;

    const MINE = 'M';
    const EMPTY = 'E';

    public function checkCell($grid, $row, $column)
    {
        $this->grid = $grid;
        $this->cellToCheck = array('row' => $row, 'column' => $column);

        if ($this->hasMine($this->cellToCheck['row'], $this->cellToCheck['column'])) {
            $this->revealedCells[] = array(
                'row' => $this->cellToCheck['row'],
                'column' => $this->cellToCheck['column'],
                'mine' => true,
                'adjacentMines' => 0
            );
        } else {
            $this->revealedCells[] = array(
                'row' => $this->cellToCheck['row'],
                'column' => $this->cellToCheck['column'],
                'mine' => false,
                'adjacentMines' => self::$adjacentMines
            );

            $this->revealAdjacentCells();
        }

        return $this->revealedCells;
    }

    protected function hasMine($row, $col)
    {
        $content = $this->grid->marks()->where('row', $row)->where('column', $col)->get();

        return !$content->isEmpty();
    }

    public function revealAdjacentCells()
    {
        $this->revealNWCell();
        dd($this->revealedCells);
        $this->revealNorthCell();
        $this->revealNECell();
        $this->revealEastCell();
        $this->revealSECell();
        $this->revealSouthCell();
        $this->revealSWCell();
        $this->revealWestCell();

        return $this->revealedCells;
    }

    protected function revealNWCell()
    {
        if ($this->cellToCheck['row'] == 1 || $this->cellToCheck['column'] == 1) { return; }
        echo "Checking NW Cell\n";

        if ($this->CellAlreadyVisited($this->cellToCheck)) { return; }

        $this->checkCell($this->grid, $this->cellToCheck['row'] - 1, $this->cellToCheck['column'] - 1);
    }

    protected function revealNorthCell()
    {
        if ($this->cellToCheck['row'] == 1) { return; }
        echo "Checking North Cell\n";

        if ($this->CellAlreadyVisited($this->cellToCheck)) { return; }

        $this->checkCell($this->grid, $this->cellToCheck['row'] - 1, $this->cellToCheck['column']);
    }

    protected function revealNECell()
    {
        if ($this->cellToCheck['row'] == 1 || $this->cellToCheck['column'] == $this->grid->columns) { return; }
        echo "Checking NE Cell\n";

        if ($this->CellAlreadyVisited($this->cellToCheck)) { return; }

        $this->checkCell($this->grid, $this->cellToCheck['row'] - 1, $this->cellToCheck['column'] + 1);
    }

    protected function revealEastCell()
    {
        if ($this->cellToCheck['column'] == $this->grid->columns) { return; }
        echo "Checking East Cell\n";

        if ($this->CellAlreadyVisited($this->cellToCheck)) { return; }

        $this->checkCell($this->grid, $this->cellToCheck['row'], $this->cellToCheck['column'] + 1);
    }

    protected function revealSECell()
    {
        if ($this->cellToCheck['row'] == $this->grid->rows || $this->cellToCheck['column'] == $this->grid->columns) { return; }
        echo "Checking SE Cell\n";

        if ($this->CellAlreadyVisited($this->cellToCheck)) { return; }

        $this->checkCell($this->grid, $this->cellToCheck['row'] + 1, $this->cellToCheck['column'] + 1);
    }

    protected function revealSouthCell()
    {
        if ($this->cellToCheck['row'] == $this->grid->rows) { return; }
        echo "Checking South Cell\n";

        if ($this->CellAlreadyVisited($this->cellToCheck)) { return; }

        $this->checkCell($this->grid, $this->cellToCheck['row'] + 1, $this->cellToCheck['column']);
    }

    protected function revealSWCell()
    {
        if ($this->cellToCheck['row'] == $this->grid->rows || $this->cellToCheck['column'] == 1) { return; }
        echo "Checking SW Cell\n";

        if ($this->cellAlreadyVisited($this->cellToCheck)) { return; }

        $this->checkCell($this->grid, $this->cellToCheck['row'] + 1, $this->cellToCheck['column'] - 1);
    }

     protected function revealWestCell()
    {
        if ($this->cellToCheck['column'] == 1) { return; }
        echo "Checking West Cell\n";

        if ($this->CellAlreadyVisited($this->cellToCheck)) { return; }

        $this->checkCell($this->grid, $this->cellToCheck['row'], $this->cellToCheck['column'] - 1);
    }

    protected function cellAlreadyVisited($cell)
    {
        if (in_array($cell, $this->revealedCells)) { return true; }

        return false;
    }
}
