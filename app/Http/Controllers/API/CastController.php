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
use App\Exceptions\NoSuchSectionExistsException;
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
        if (requestContainsMultipleObjects()) {
            $casts = array();
            DB::beginTransaction();

            foreach ($request->all() as $data) {
                try {
                    $casts[] = $this->createCast(
                        $data['user_id'],
                        $data['game_id'],
                        $data['pie_value'],
                        $data['multiplier']
                    );
                } catch (NoSuchSectionExistsException $e) {
                    DB::rollBack();
                    return response([
                        'errors' => [
                            $e->getMessage()
                        ]
                    ], 422)->header('Content-Type', 'application/json');
                }
            }

            DB::commit();
            return fractal()
                ->collection($casts)
                ->transformWith(new CastTransformer)
                ->parseExcludes('user')
                ->parseExcludes('game')
                ->toArray();
        } else {
            $cast = $this->createCast($request->user_id, $request->game_id, $request->pie_value, $request->multiplier);
            return fractal()
                ->item($cast)
                ->transformWith(new CastTransformer)
                ->parseExcludes('user')
                ->parseExcludes('game')
                ->toArray();
        }
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
     * Update multiple Casts in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateMultiple(UpdateCastRequest $request)
    {
        if (requestContainsMultipleObjects()) {
            $casts = array();
            DB::beginTransaction();

            foreach ($request->all() as $data) {
                try {
                    $cast = Cast::find($data['id']);
                    $casts[] = $this->updateCast(
                        $data['id'],
                        $data['user_id'] ?? $cast->user_id,
                        $data['game_id'] ?? $cast->game_id,
                        $data['pie_value'] ?? $cast->point()->pie_value,
                        $data['multiplier'] ?? $cast->multiplier()->value
                    );
                } catch (NoSuchSectionExistsException $e) {
                    DB::rollBack();
                    return response([
                        'errors' => [
                            $e->getMessage()
                        ]
                    ], 422)->header('Content-Type', 'application/json');
                }
            }

            DB::commit();
            return fractal()
                ->collection($casts)
                ->transformWith(new CastTransformer)
                ->parseExcludes('user')
                ->parseExcludes('game')
                ->toArray();
        } else {
            return response([
                'errors' => [
                    'Request need to contain multiple objects. To update single object use PATCH /throws/{id}. '
                ]
            ], 400)->header('Content-Type', 'application/json');
        }
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

    private function createCast($user_id, $game_id, $pie_value, $multiplier_value)
    {
        $cast = new Cast;
        $user = User::find($user_id);
        $game = Game::find($game_id);
        $multiplier = DB::table('multipliers')->where('value', $multiplier_value)->first();
        $point = DB::table('points')
            ->where('pie_value', $pie_value)
            ->where('multiplier_id', $multiplier->id)
            ->first();

        if (!$point) {
            throw new NoSuchSectionExistsException(
                sprintf(
                    "No such combination of multiplier (%d) and pie value (%d) exists.",
                    $multiplier_value,
                    $pie_value
                )
            );
        }

        $cast->user()->associate($user);
        $cast->game()->associate($game);
        $cast->point_id = $point->id;

        $cast->save();

        return $cast;
    }

    private function updateCast($throws_id, $user_id, $game_id, $pie_value, $multiplier_value)
    {
        $cast = Cast::find($throws_id);

        if (!$cast) {
            abort(\Illuminate\Http\Response::HTTP_NOT_FOUND);
        }
        $user = User::find($user_id);
        $game = Game::find($game_id);
        $multiplier = DB::table('multipliers')
            ->where('value', $multiplier_value)
            ->first();
        $point = DB::table('points')
            ->where('pie_value', $pie_value)
            ->where('multiplier_id', $multiplier->id)
            ->first();

        if (!$point) {
            throw new NoSuchSectionExistsException(
                sprintf(
                    "No such combination of multiplier (%d) and pie value (%d) exists.",
                    $multiplier_value,
                    $pie_value
                )
            );
        }

        $cast->user()->associate($user);
        $cast->game()->associate($game);
        $cast->point_id = $point->id;

        $cast->save();

        return $cast;
    }
}
