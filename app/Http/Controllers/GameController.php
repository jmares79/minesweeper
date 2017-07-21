<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Service\Game\GameService;
use App\Game;

class GameController extends Controller
{
    protected $game;

    public function __construct(GameService $game)
    {
        $this->game = $game;
    }

    /**
     * @ApiDescription(section="Game", description="Handles the creation of a new game")
     * @ApiMethod(type="post")
     * @ApiRoute(name="/game/{rows}/{columns}/{mines}")
     * @ApiParams(name="rows", type="integer")
     * @ApiParams(name="columns", type="integer")
     * @ApiParams(name="mines", type="integer")
     * @ApiReturnHeaders("HTTP 201 CREATED")
     * @ApiReturnHeaders("HTTP 422 UNPROCESSABLE_ENTITY")
     * @ApiReturnHeaders("HTTP 400 BAD_REQUEST")
     * @ApiReturn(type="JsonResponse")
     */
    public function newGame($rows, $columns, $mines)
    {
        if (!$this->game->isValidGrid($rows, $columns, $mines)) return response()->json(['http' => Response::UNPROCESSABLE_ENTITY]);

        try {
            $game = $this->game->createGame($rows, $columns, $mines);

            return response(Response::HTTP_CREATED)->header('Location', url('/game', $game->id));
        } catch (CreationException $e) {
            return response()->json(['http' => Response::HTTP_BAD_REQUEST]);
        }
    }

    /**
     * @ApiDescription(section="Game", description="Gets a game by its id")
     * @ApiMethod(type="get")
     * @ApiRoute(name="/game/{id}")
     * @ApiParams(name="id", type="integer")
     * @ApiReturnHeaders("HTTP 200 OK")
     * @ApiReturnHeaders("HTTP 404 NOT_FOUND")
     * @ApiReturn(type="JsonResponse")
     */
    public function getGame($id)
    {
        $game = \App\Game::find($id);

        if ($game == null) { return response()->json(['http' => Response::HTTP_NOT_FOUND]); }

        return response()->json(['http' => Response::HTTP_OK, 'game' => $game]);
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
