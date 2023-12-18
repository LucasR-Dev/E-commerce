<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Mail\UserCreated;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreUserFormRequest;
use App\Http\Requests\UpdateUserFormRequest;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(5);

        return UserResource::collection($users);
    }
    public function store(StoreUserFormRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $newUser = User::create($data);

        Mail::to($newUser)->send(new UserCreated($newUser));

        return response()->json([
            'message' => 'User created successfully!',
            'data' => $newUser
        ]);
    }

    public function update(UpdateUserFormRequest $request, int $id): JsonResponse
    {
        $user = User::find($id);
        $updateUser = $request->validated();

        if ($user->name != $updateUser['name']) {
            $user->fill($updateUser)->save();
        } else {

            return response()->json([
                'message' => 'The name has already been taken'
            ]);
        }

        return response()->json([
            'message' => 'User updated successfully!',
            'data' => $user
        ]);
    }

    public function destroy(string $user)
    {
        Product::destroy($user);
        return ['message' => 'User deleted successfully.'];
    }

    public function show(string $id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['error' => 'User not found.'], 404);
        }
    }
}
