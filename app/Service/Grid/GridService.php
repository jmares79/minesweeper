<?php

namespace App\Service\Grid;

use App\Interfaces\GridCalculatorInterface;
use App\Grid;
use App\Mark;

class GridService implements GridCalculatorInterface
{
    protected $grid;
    protected $cellToCheck = array();
    protected $visitedCells = array();
    protected $revealedCells = array();

    public function checkCell($grid, $row, $column)
    {
        $this->grid = $grid;
        $hasMine = $this->hasMine($row, $column);

        if ($hasMine && $this->firstCheck($row, $column)) {
            return $this->revealedCells[] = array(
                'row' => $row,
                'column' => $column,
                'mine' => true,
                'adjacentMines' => 0
            );
        } else {
            $this->revealAdjacentCells($row, $column);
        }

        return $this->revealedCells;

        // if ($hasMine && !$this->firstCheck($row, $column)) {
        //     $cell = array_pop($this->cellStack);
        //     $cell['adjacentMines']++;
        //     $this->cellStack[] = $cell;

        //     return;
        // } else {
        //     $this->cellStack[] = array(
        //         'row' => $row,
        //         'column' => $column,
        //         'mine' => false,
        //         'adjacentMines' => 0
        //     );

        //     $this->revealAdjacentCells($row, $column);

        //     $cell = array_pop($this->cellStack);
        //     $this->revealedCells[] = $cell;
        // }

        // if (empty($this->cellStack)) {
        //     return $this->revealedCells;
        // } else {
        //     $this->revealAdjacentCells($cell['row'], $cell['column']);
        // }
    }


    public function revealAdjacentCells($row, $column)
    {
        echo "HERE with row: $row - col: $column<br>";
        $this->visitedCells[] = array('row' => $row, 'column' => $column);

        if ($this->coordinatesOutOfBounds($row, $column)) { echo "COOB<br>"; return; }
        if ($this->cellAlreadyVisited($row, $column)) { echo "CAV<br>"; return; }
        echo "passed checks<br>";

        //The bug here is that when popping, obviously is only the last one! So that's the one that gets updated
        //Instead I have to find the one belonging to $row & $column and update that!
        if ($this->hasMine($row, $column)) {
            $cell = array_pop($this->revealedCells);
            $cell['adjacentMines']++;
            $this->revealedCells[] = $cell;

            echo "<pre> MINE in row: $row - col: $column FROM CELL: ". $cell['row'] . "-" . $cell['row'] ."</pre>";
            echo "<pre>"; var_dump($cell); echo "</pre>";

            return;
        } else {
            echo "<pre> ADDING cell $row - $column to array</pre>";

            $this->revealedCells[] = array(
                'row' => $row,
                'column' => $column,
                'mine' => false,
                'adjacentMines' => 0
            );

            echo "<pre>"; var_dump($this->revealedCells); echo "</pre>";
        }

        $this->revealAdjacentCells($row - 1, $column - 1); //NW
        $this->revealAdjacentCells($row - 1, $column); //North
        $this->revealAdjacentCells($row - 1, $column + 1); //NE
        $this->revealAdjacentCells($row, $column + 1); //East
        $this->revealAdjacentCells($row + 1, $column + 1); //SE
        $this->revealAdjacentCells($row + 1, $column); //South
        $this->revealAdjacentCells($row + 1, $column - 1); //SW
        $this->revealAdjacentCells($row, $column - 1); //West
        // dd($this->revealedCells);
    }

    protected function hasMine($row, $col)
    {
        $content = $this->grid->marks()->where('row', $row)->where('column', $col)->get();

        return !$content->isEmpty();
    }

    protected function firstCheck($row, $col)
    {
        return empty($this->revealedCells);
    }

    // protected function revealNWCell()
    // {
    //     if ($this->cellToCheck['row'] == 1 || $this->cellToCheck['column'] == 1) { return; }
    //     echo "<pre>"; var_dump($this->cellToCheck); echo "</pre>";
    //     echo "Checking NW Cell\n";

    //     if ($this->CellAlreadyVisited($this->cellToCheck)) { return; }

    //     $this->checkCell($this->grid, $this->cellToCheck['row'] - 1, $this->cellToCheck['column'] - 1);
    // }

    // protected function revealNorthCell()
    // {
    //     if ($this->cellToCheck['row'] == 1) { return; }
    //     echo "Checking North Cell\n";
    //     echo "<pre>"; var_dump($this->cellToCheck); echo "</pre>";

    //     if ($this->CellAlreadyVisited($this->cellToCheck)) { return; }

    //     $this->checkCell($this->grid, $this->cellToCheck['row'] - 1, $this->cellToCheck['column']);
    // }

    // protected function revealNECell()
    // {
    //     if ($this->cellToCheck['row'] == 1 || $this->cellToCheck['column'] == $this->grid->columns) { return; }
    //     echo "Checking NE Cell\n";

    //     if ($this->CellAlreadyVisited($this->cellToCheck)) { return; }

    //     $this->checkCell($this->grid, $this->cellToCheck['row'] - 1, $this->cellToCheck['column'] + 1);
    // }

    // protected function revealEastCell()
    // {
    //     if ($this->cellToCheck['column'] == $this->grid->columns) { return; }
    //     echo "Checking East Cell\n";

    //     if ($this->CellAlreadyVisited($this->cellToCheck)) { return; }

    //     $this->checkCell($this->grid, $this->cellToCheck['row'], $this->cellToCheck['column'] + 1);
    // }

    // protected function revealSECell()
    // {
    //     if ($this->cellToCheck['row'] == $this->grid->rows || $this->cellToCheck['column'] == $this->grid->columns) { return; }
    //     echo "Checking SE Cell\n";

    //     if ($this->CellAlreadyVisited($this->cellToCheck)) { return; }

    //     $this->checkCell($this->grid, $this->cellToCheck['row'] + 1, $this->cellToCheck['column'] + 1);
    // }

    // protected function revealSouthCell()
    // {
    //     if ($this->cellToCheck['row'] == $this->grid->rows) { return; }
    //     echo "Checking South Cell\n";

    //     if ($this->CellAlreadyVisited($this->cellToCheck)) { return; }

    //     $this->checkCell($this->grid, $this->cellToCheck['row'] + 1, $this->cellToCheck['column']);
    // }

    // protected function revealSWCell()
    // {
    //     if ($this->cellToCheck['row'] == $this->grid->rows || $this->cellToCheck['column'] == 1) { return; }
    //     echo "Checking SW Cell\n";

    //     if ($this->cellAlreadyVisited($this->cellToCheck)) { return; }

    //     $this->checkCell($this->grid, $this->cellToCheck['row'] + 1, $this->cellToCheck['column'] - 1);
    // }

    // protected function revealWestCell()
    // {
    //     if ($this->cellToCheck['column'] == 1) { return; }
    //     echo "Checking West Cell\n";

    //     if ($this->CellAlreadyVisited($this->cellToCheck)) { return; }

    //     $this->checkCell($this->grid, $this->cellToCheck['row'], $this->cellToCheck['column'] - 1);
    // }

    protected function coordinatesOutOfBounds($row, $column)
    {
        if ($row < 1 || $row > $this->grid->rows ||
            $column > $this->grid->columns || $column < 1) {
            return true;
        } else {
            return false;
        }
    }

    protected function cellAlreadyVisited($row, $column)
    {
        foreach ($this->revealedCells as $cell) {
            if ($cell['row'] == $row && $cell['column'] == $column) { return true;}
        }
        // $cell['row'] = $row;
        // $cell['column'] = $column;
        // echo "<pre>"; var_dump($cell); echo "</pre>";
        // echo "<pre>"; var_dump($this->revealedCells); echo "</pre>";
        // dd($this->revealedCells);
        // if (in_array($cell, $this->revealedCells)) { return true; }

        return false;
    }
}
