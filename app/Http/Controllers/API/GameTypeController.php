<?php

namespace App\Http\Controllers\API;

use App\GameType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Transformers\GameTypeTransformer;
use App\Http\Requests\UpdateGameTypeRequest;
use App\Http\Requests\StoreGameTypeRequest;

class GameTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gameTypes = GameType::all();
        return fractal()
            ->collection($gameTypes)
            ->transformWith(new GameTypeTransformer)
            ->toArray();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGameTypeRequest $request)
    {
        if (requestContainsMultipleObjects()) {
           $gameTypes = array();

           DB::beginTransaction();

           foreach ($request->all() as $data) {
               $gameType = new GameType;
               $gameType->name = $data['name'];
               $gameType->description = $data['description'];

               $gameType->save();

               $gameTypes[] = $gameType;
           }
           DB::commit();

           return fractal()
                ->collection($gameTypes)
                ->transformWith(new GameTypeTransformer)
                ->toArray();
        } else {
            $gameType = new GameType;
            $gameType->name = $request->name;
            $gameType->description = $request->description;

            $gameType->save();

            return fractal()
                ->item($gameType)
                ->transformWith(new GameTypeTransformer)
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
        $gameType = GameType::find($id);

        if (!$gameType) {
            abort(\Illuminate\Http\Response::HTTP_NOT_FOUND);
        }

        return fractal()
            ->item($gameType)
            ->transformWith(new GameTypeTransformer)
            ->toArray();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGameTypeRequest $request, $id)
    {
        $gameType = GameType::find($id);

        if (!$gameType) {
            abort(\Illuminate\Http\Response::HTTP_NOT_FOUND);
        }

        $gameType->name = $request->input('name', $gameType->name);
        $gameType->description = $request->input('description', $gameType->description);

        $gameType->save();

        return fractal()
            ->item($gameType)
            ->transformWith(new GameTypeTransformer)
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
        $gameType = GameType::find($id);

        if (!$gameType) {
            abort(\Illuminate\Http\Response::HTTP_NOT_FOUND);
        }

        $gameType->delete();

        return response(null, 204);
    }
}
