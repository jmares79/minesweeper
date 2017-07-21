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

    /**
     * @ApiDescription(section="App\Service\Game", description="Creates the game")
     * @ApiReturn(type="game")
     */
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

    /**
     * @ApiDescription(section="App\Service\Game", description="Creates the grid")
     * @ApiReturn(type="grid")
     */
    protected function createGrid($rows, $columns, $mines)
    {
        $grid = new Grid();

        $grid->rows = $rows;
        $grid->columns = $columns;
        $grid->mines = $mines;

        return $grid;
    }

    /**
     * @ApiDescription(section="App\Service\Game", description="Sets the mines on the grid")
     * @ApiReturn(type="void")
     */
    public function setMinesOnGrid($grid, $rows, $columns, $mines)
    {
        while ($mines > 0) {
            $r = rand(1, $rows);
            $c = rand(1, $columns);

            $this->createMark($grid, $r, $c);

            $mines--;
        }
    }

    /**
     * @ApiDescription(section="App\Service\Game", description="Creates a mark")
     * @ApiReturn(type="void")
     */
    protected function createMark($grid, $row, $col)
    {
        $mark = new Mark();

        $mark->row = $row;
        $mark->column = $col;
        $mark->type = self::MINE;
        $grid->marks()->save($mark);
        $mark->save();
    }

    /**
     * @ApiDescription(section="App\Service\Game", description="Check if the gris is valid")
     * @ApiReturn(type="boolean")
     */
    public function isValidGrid($rows, $columns, $mines)
    {
        if ($mines >= $rows * $columns) return false;

        return true;
    }
}
