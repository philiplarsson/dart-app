<?php

namespace App\Http\Controllers\API;

use App\Cast;
use App\User;
use App\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Transformers\CastTransformer;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCastRequest;
use App\Http\Requests\UpdateCastRequest;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class CastController extends Controller
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
            $paginator = Cast::oldestFirst()->paginate(50);
        } else {
            $paginator = Cast::latestFirst()->paginate(50);
        }

        $castCollection = $paginator->getCollection();

        return fractal()
            ->collection($castCollection)
            ->transformWith(new CastTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->toArray();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCastRequest $request)
    {
        $cast = new Cast;

        $user = User::find($request->user_id);
        $game = Game::find($request->game_id);
        $multiplier = DB::table('multipliers')->where('value', $request->multiplier)->first();
        $point = DB::table('points')
            ->where('pie_value', $request->pie_value)
            ->where('multiplier_id', $multiplier->id)
            ->first();

        if (!$point) {
            return response([
                'errors' => [
                    'No such combination of multiplier and pie value exists. '
                    ]
                ], 422)->header('Content-Type', 'application/json');
        }
        $cast->user()->associate($user);
        $cast->game()->associate($game);
        $cast->point_id = $point->id;

        $cast->save();

        return fractal()
            ->item($cast)
            ->transformWith(new CastTransformer)
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
        $cast = Cast::find($id);

        if (!$cast) {
            abort(\Illuminate\Http\Response::HTTP_NOT_FOUND);
        }

        return fractal()
            ->item($cast)
            ->transformWith(new CastTransformer)
            ->toArray();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCastRequest $request, $id)
    {
        $cast = Cast::find($id);

        if (!$cast) {
            abort(\Illuminate\Http\Response::HTTP_NOT_FOUND);
        }

        $user = User::find($request->input('user_id', $cast->user_id));
        $game = Game::find($request->input('game_id', $cast->game_id));
        $multiplier = DB::table('multipliers')
            ->where('value', $request->input('multiplier', $cast->multiplier()->value))
            ->first();
        $point = DB::table('points')
            ->where('pie_value', $request->input('pie_value', $cast->point()->pie_value))
            ->where('multiplier_id', $multiplier->id)
            ->first();

        if (!$point) {
            return response([
                'errors' => [
                    'No such combination of multiplier and pie value exists. '
                    ]
                ], 422)->header('Content-Type', 'application/json');
        }

        $cast->user()->associate($user);
        $cast->game()->associate($game);
        $cast->point_id = $point->id;

        $cast->save();

        return fractal()
            ->item($cast)
            ->transformWith(new CastTransformer)
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
        $cast = Cast::find($id);

        if (!$cast) {
            abort(\Illuminate\Http\Response::HTTP_NOT_FOUND);
        }

        $cast->delete();

        return response(null, 204);
    }
}
