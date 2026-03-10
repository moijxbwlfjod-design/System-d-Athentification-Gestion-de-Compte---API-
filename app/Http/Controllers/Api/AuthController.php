<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'gender' => 'required|in:male,female'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
        ]);
        Auth::login($user);
        $token = $user->createToken($user->name);
        return response()->json([
            'message' => 'account created successfully',
            'token' => $token->plainTextToken
        ], 201);
    }
    
    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        if (Auth::attempt($credentials)){
            $user = Auth::user();
            $token = $user->createToken($user->id);
            return response()->json([
                'message' => 'welcome again',
                'token' => $token
            ], 200);
        }
        return response()->json([
            'message' => 'please give valide cridentials'
        ], 404);
    }
}
