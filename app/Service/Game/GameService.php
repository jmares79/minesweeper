<?php

namespace App\Service\Game;

use App\Interfaces\GameCreatorInterface;
use App\Game;
use App\Grid;

class GameService implements GameCreatorInterface
{
    public function createGame($rows, $columns, $mines)
    {
        $game = new Game();

        $game->status = 1;
        $game->started = false;
        $game->saved = false;
        $game->resumed = false;
        $game->save();

        $grid = $this->createGrid($rows, $columns, $mines);

        $game->grid()->save($grid);

        return $game;
    }

    protected function createGrid($rows, $columns, $mines)
    {
        $grid = new Grid();

        $grid->rows = $rows;
        $grid->columns = $columns;
        $grid->mines = $mines;
        $grid->completed = false;

        return $grid;
    }
}
