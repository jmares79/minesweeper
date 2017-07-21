<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Service\Grid\GridService;
use App\Grid;

class GridController extends Controller
{
    protected $grid;

    public function __construct(GridService $grid)
    {
        $this->grid = $grid;
    }

    /**
     * @ApiDescription(section="Grid", description="Check the status of a cell for a certain grid")
     * @ApiMethod(type="get")
     * @ApiRoute(name="/checkCell/{grid}/{row}/{column}")
     * @ApiParams(name="grid", type="integer")
     * @ApiParams(name="row", type="integer")
     * @ApiParams(name="column", type="integer")
     * @ApiReturnHeaders("HTTP 201 OK")
     * @ApiReturnHeaders("HTTP 400 BAD_REQUEST")
     * @ApiReturn(type="JsonResponse", description="Returns the content of the cell, or an array with empty cells until finding a mine neighbour")
     */
    public function checkCell($gridId, $row, $column)
    {
        $grid = Grid::find($gridId);

        if ($grid == null) { return response()->json(['http' => Response::HTTP_NOT_FOUND]); }

        $result = $this->grid->checkCell($grid, $row, $column);

        return response()->json(['http' => Response::HTTP_OK, 'cells' => $cells]);
    }

    public function markCell($row, $column)
    {
        echo "markCell";
    }
}
