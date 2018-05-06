<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Cast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Transformers\CastTransformer;
use App\Transformers\UserTransformer;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Response;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = User::paginate(10);
        $userCollection = $paginator->getCollection();

        return fractal()
            ->collection($userCollection)
            ->transformWith(new UserTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->toArray();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        if (requestContainsMultipleObjects()) {
            $users = array();
            DB::beginTransaction();

            foreach ($request->all() as $data) {
                $users[] = $this->createUser(
                    $data["name"],
                    $data["username"],
                    $data["email"],
                    $data["password"]
                );
            }
            DB::commit();

            return fractal()
                ->collection($users)
                ->transformWith(new UserTransformer)
                ->toArray();
        } else {
            $user = $this->createUser(
                $request->input('name'),
                $request->input('username'),
                $request->input('email'),
                $request->input('password')
            );

            return fractal()
                ->item($user)
                ->transformWith(new UserTransformer)
                ->toArray();
        }
    }

    private function getUserTypeId()
    {
        return DB::table('user_types')->where('type', 'user')->first()->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            abort(\Illuminate\Http\Response::HTTP_NOT_FOUND);
        }

        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->toArray();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            abort(\Illuminate\Http\Response::HTTP_NOT_FOUND);
        }

        $user->username = $request->input('username', $user->username);
        $user->email = $request->input('email', $user->email);
        $user->name = $request->input('name', $user->name);
        $user->save();

        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->toArray();
    }

    /**
     * Update multiple Throws in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateMultiple(UpdateUserRequest $request)
    {
        if (requestContainsMultipleObjects()) {
            $users = array();
            DB::beginTransaction();

            foreach ($request->all() as $data) {
                $user = User::find($data['id']);
                $user->name = $data['name'] ?? $user->name;
                $user->username = $data['username'] ?? $user->username;
                $user->email = $data['email'] ?? $user->email;

                $user->save();

                $users[] = $user;
            }

            DB::commit();

            return fractal()
                ->collection($users)
                ->transformWith(new UserTransformer)
                ->toArray();

        } else {
            return response([
                    'errors' => [
                        'Request need to contain multiple objects. To update single object use PATCH /users/{id}. '
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
        $user = User::find($id);

        if (!$user) {
            abort(\Illuminate\Http\Response::HTTP_NOT_FOUND);
        }

        $user->delete();

        return response(null, 204);
    }

    public function throws($id)
    {
        $user = User::find($id);

        if (!$user) {
            abort(\Illuminate\Http\Response::HTTP_NOT_FOUND);
        }

        $paginator = $user->casts()->paginate(50);
        $castCollection = $paginator->getCollection();

        return fractal()
            ->collection($castCollection)
            ->transformWith(new CastTransformer)
            ->parseExcludes('user')
            ->parseExcludes('game')
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->toArray();
    }

    private function createUser($name = '', $user_name, $email, $password)
    {
        $user = new User;
        $user->username = $user_name;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->name = $name;
        $user->type_id = $this->getUserTypeId();

        $user->save();

        return $user;
    }
}
