<?php

namespace App\Http\Controllers\API;

use App\Game;
use App\GameType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\GameTransformer;
use App\Transformers\CastTransformer;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sortBy = $request->query('sort_by');
        if ($sortBy === 'asc') {
            $paginator = Game::oldestFirst()->paginate(10);
        } else {
            $paginator = Game::latestFirst()->paginate(10);
        }

        $gameCollection = $paginator->getCollection();

        return fractal()
            ->collection($gameCollection)
            ->transformWith(new GameTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->toArray();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGameRequest $request)
    {
        $game = new Game;
        $gameType = GameType::find($request->input('game_type_id'));
        $game->gameType()->associate($gameType);

        $game->save();

        return fractal()
            ->item($game)
            ->transformWith(new GameTransformer)
            ->toArray();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = Game::find($id);

        if (!$game) {
            abort(\Illuminate\Http\Response::HTTP_NOT_FOUND);
        }

        return fractal()
            ->item($game)
            ->transformWith(new GameTransformer)
            ->toArray();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGameRequest $request, $id)
    {
        $game = Game::find($id);

        if (!$game) {
            abort(\Illuminate\Http\Response::HTTP_NOT_FOUND);
        }

        $gameType = GameType::find($request->input('game_type_id'));
        $game->gameType()->associate($gameType);

        $game->save();

        return fractal()
            ->item($game)
            ->transformWith(new GameTransformer)
            ->toArray();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $game = Game::find($id);

        if (!$game) {
            abort(\Illuminate\Http\Response::HTTP_NOT_FOUND);
        }

        $game->delete();

        return response(null, 204);
    }

    public function throws($id)
    {
        $game = Game::find($id);

        if (!$game) {
            abort(\Illuminate\Http\Response::HTTP_NOT_FOUND);
        }

        $paginator = $game->casts()->paginate(50);
        $castCollection = $paginator->getCollection();

        return fractal()
            ->collection($castCollection)
            ->transformWith(new CastTransformer)
            ->parseExcludes('user')
            ->parseExcludes('game')
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->toArray();
    }
}
