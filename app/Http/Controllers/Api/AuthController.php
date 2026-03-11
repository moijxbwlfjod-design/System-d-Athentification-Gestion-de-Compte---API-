<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function register(RegisterRequest $request){
        $data = $request->validated();
        $user = User::create($data);
        Auth::login($user);
        $token = $user->createToken($user->name);
        return response()->json([
            'message' => 'account created successfully',
            'token' => $token->plainTextToken
        ], 201);
    }
    
    public function login(LoginRequest $request){
        $credentials = $request->validated();
        if (Auth::attempt($credentials)){
            $token = Auth::user()->createToken(Auth::user()->id);
            return response()->json([
                'message' => 'welcome again',
                'token' => $token->plainTextToken
            ], 200);
        }
        return response()->json([
            'message' => 'please give valide cridentials'
        ], 404);
    }
}
