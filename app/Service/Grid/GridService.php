<?php

namespace App\Service\Grid;

use App\Interfaces\GridCalculatorInterface;
use App\Grid;
use App\Mark;

class GridService implements GridCalculatorInterface
{
    protected $grid;
    protected $adjacentMines;
    protected $cellToCheck = array();
    protected $returnedList = array();
    protected $revealedCells = array();

    public function checkCell($grid, $row, $column)
    {
        $this->grid = $grid;
        $hasMine = $this->hasMine($row, $column);

        if ($hasMine) {
            return $this->revealedCells[] = array(
                'row' => $row,
                'column' => $column,
                'mine' => true,
                'adjacentMines' => null
            );
        } if (!$hasMine && $this->hasAdjacentMines($row, $column)) {
            return $this->revealedCells[] = array(
                'row' => $row,
                'column' => $column,
                'mine' => false,
                'adjacentMines' => count($this->adjacentMines)
            );
        } else {
            $this->revealAdjacentCells($row, $column);
        }

        return $this->returnedList;
    }
    
    protected function hasAdjacentMines($row, $column)
    {
        $minesInGrid = $this->grid->marks()->where('type', 'M')->get();
        $this->adjacentMines = $this->getAdjancentMines($row, $column, $minesInGrid);

        return (count($this->adjacentMines) > 0);
    }

    protected function getAdjancentMines($row, $column, $minesInGrid)
    {
        $mines = $minesInGrid->filter(function($mine) use ($row, $column) {
            return (
                ($mine->row == $row - 1 && $mine->column == $column - 1) || 
                ($mine->row == $row - 1 && $mine->column == $column)     || 
                ($mine->row == $row - 1 && $mine->column == $column + 1) || 
                ($mine->row == $row     && $mine->column == $column + 1) || 
                ($mine->row == $row + 1 && $mine->column == $column + 1) || 
                ($mine->row == $row + 1 && $mine->column == $column)     || 
                ($mine->row == $row + 1 && $mine->column == $column - 1) || 
                ($mine->row == $row     && $mine->column == $column - 1)
            );
        });

        return $mines;
    }

    public function revealAdjacentCells($row, $column)
    {
        echo "HERE with row: $row - col: $column<br>";

        if ($this->coordinatesOutOfBounds($row, $column)) { echo "COOB<br>"; return; }
        if ($this->cellAlreadyVisited($row, $column)) { echo "CAV<br>"; return; }
        echo "passed checks<br>";

        //The bug here is that when popping, obviously is only the last one! So that's the one that gets updated
        //Instead I have to find the one belonging to $row & $column and update that!
        if ($this->hasMine($row, $column)) {
            $cell = array_pop($this->revealedCells);
            $cell['adjacentMines']++;
            $this->revealedCells[] = $cell;

            echo "<pre> MINE in row: $row - col: $column FROM CELL: ". $cell['row'] . "-" . $cell['column'] ."</pre>";
            echo "<pre>"; var_dump($cell); echo "</pre>";

            return;
        } else {
            echo "<pre> ADDING cell $row - $column to array</pre>";

            $this->revealedCells[] = array(
                'row' => $row,
                'column' => $column,
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

        $final = array_pop($this->revealedCells);
        if (!$this->alreadyLoaded($final)) { $this->returnedList[] = $final; }
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

    protected function alreadyLoaded($cell)
    {
        foreach ($this->returnedList as $c) {
            if ($c['row'] == $cell['row'] && $c['column'] == $cell['column']) { return true;}
        }

        return false;
    }

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

        return false;
    }
}
