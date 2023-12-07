<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\UserCreated;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreUpdateUserFormRequest;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateUserFormRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $this->handleProductExists('name', $request->name);
                
        $newUser = User::create($data);
       

        Mail::to($newUser)->send(new UserCreated($newUser));

        return response()->json([
            'message' => 'Usuário criado com sucesso!',
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function handleProductExists($validate, $param)
    {
        $model = User::where($validate, $param);

        abort_if($model->exists(), Response::HTTP_UNPROCESSABLE_ENTITY, 'The name is already being used.');
    }


}
