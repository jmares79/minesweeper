<?php

namespace App\Service\Game;

use App\Interfaces\GameCreatorInterface;
use App\Game;
use App\Grid;
use App\Mark;

class GameService implements GameCreatorInterface
{
    const CREATED = 0;
    const STARTED = 1;
    const FINISHED = 2;
    const MINE = 'M';

    public function createGame($rows, $columns, $mines)
    {
        $game = new Game();

        $game->status = self::CREATED;
        $game->save();

        $grid = $this->createGrid($rows, $columns, $mines);
        $game->grid()->save($grid);

        $this->setMinesOnGrid($grid, $rows, $columns, $mines);

        return $game;
    }

    protected function createGrid($rows, $columns, $mines)
    {
        $grid = new Grid();

        $grid->rows = $rows;
        $grid->columns = $columns;
        $grid->mines = $mines;

        return $grid;
    }

    public function setMinesOnGrid($grid, $rows, $columns, $mines)
    {
        while ($mines > 0) {
            $r = rand(1, $rows);
            $c = rand(1, $columns);

            $this->createMark($grid, $r, $c);

            $mines--;
        }
    }

    protected function createMark($grid, $row, $col)
    {
        $mark = new Mark();

        $mark->row = $row;
        $mark->column = $col;
        $mark->type = self::MINE;
        $grid->marks()->save($mark);
        $mark->save();
    }

    public function isValidGrid($rows, $columns, $mines)
    {
        if ($mines >= $rows * $columns) return false;

        return true;
    }
}
