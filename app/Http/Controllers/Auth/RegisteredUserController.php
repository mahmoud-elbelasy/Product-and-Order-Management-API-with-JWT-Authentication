<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use Response;

class RegisteredUserController extends Controller
{
    public function store(Request $request) 
    {
      
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\password::defaults()],
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'email' => $request->email,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return Response::json([
            'user' => $user,
            'access_token' => $token,
            'type' => 'Bearer'
        ],201);
    }
}
