<?php

namespace App\Http\Controllers;

use App\Mail\UserCreated;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;

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
    public function store(Request $request)
    {
        $data = $request->toArray();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']), 
        ]);

        Mail::to($user)->send(new UserCreated($user));

        return response()->json([
            'message' => 'Usuário criado com sucesso!',
            'data' => $user
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

//     private function welcomeUser($email)
//         {
//             $mensagem = 'Obrigado por se cadastrar!';

//             Mail::raw($mensagem, function ($message) use ($email) {
//                 $message->to($email)->subject('Bem-vindo à sua aplicação');
//             });
//         }
}
