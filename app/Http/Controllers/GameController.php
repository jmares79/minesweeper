<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Service\Game\GameService as GameService;

class GameController extends Controller
{
    protected $game;

    public function __construct(GameService $game)
    {
        $this->game = $game;
    }

    public function newGame($rows, $columns, $mines)
    {
        try {
            $game = $this->game->createGame($rows, $columns, $mines);

            return response(Response::HTTP_OK)->header('Location', url('/game', $game->id));
        } catch (CreationException $e) {
            return response()->json(['http' => Response::HTTP_BAD_REQUEST]);
        }
    }

    public function getGame($id)
    {
        dd('GET GAME');
    }

    public function save()
    {
        return "save";
    }

    public function resume($id)
    {
        return "resume";
    }
}
