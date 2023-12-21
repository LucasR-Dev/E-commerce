<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\UserCreated;
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
        if(!$user){
            return response()->json(['error' => 'User not found'], 404);
        }

        $updateUser = $request->validated();
        $user->fill($updateUser)->save();

        return response()->json([
            'message' => 'User updated successfully!',
            'data' => $user
        ]);
    }

    public function destroy(int $userId): JsonResponse
    {
        $user = User::find($userId);
        if(!$user){
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted successfully.']);
    }

    public function show(int $id): JsonResponse
    {
        $user = User::find($id);
        if(!$user){
            return response()->json(['error' => 'User not found.'], 404);
        }

        return response()->json([
            'data' => $user
        ]);
    }
}
