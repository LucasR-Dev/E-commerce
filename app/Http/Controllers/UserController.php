<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\UserCreated;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreUpdateUserFormRequest;
use App\Models\Product;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd(User::all());
        return User::all()->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateUserFormRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $this->handleUserExists('name', $request->name);

        $newUser = User::create($data);


        Mail::to($newUser)->send(new UserCreated($newUser));

        return response()->json([
            'message' => 'User created successfully!',
            'data' => $newUser
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['error' => 'User not found.'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateUserFormRequest $request, string $id)
    {

        $user = User::find($id);
        $updateUser = $request->validated();

        if ($user->name != $request->name) {
            $this->handleUserExists('name', $request->name);
        }

        $user->update($updateUser);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $user)
    {
        Product::destroy($user);
        return ['message' => 'User deleted successfully.'];
    }

    private function handleUserExists($validate, $param)
    {
        $model = User::where($validate, $param);

        abort_if($model->exists(), Response::HTTP_UNPROCESSABLE_ENTITY, 'The name is already being used.');
    }
}
