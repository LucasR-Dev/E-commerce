<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function login(Request $request)
    {

        $user = User::where('email', $request->email)->first();
        if (!$user ||  !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'The provides credentials are incorrect.'
            ]);
        }

        //logout others devices
        //if ($request->has('logout_others_devices'))
        $user->tokens()->delete();

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'token' => $token,
        ]);
    }
}
