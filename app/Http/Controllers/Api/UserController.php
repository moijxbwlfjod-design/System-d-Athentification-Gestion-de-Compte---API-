<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'id' => Auth::user()->id,
            'name' => Auth::user()->name,
            'email' => Auth::user()->email
        ], 200);
    }
    public function update(UpdateRequest $request)
    {
        $data = $request->validated();
        Auth::user()->update($data);
        return response()->json(['message' => 'profile updated successfully'], 200);
    }

    public function destroy()
    {
        Auth::user()->delete();
        return response()->json(['message' => 'account removed successfully']);   
    }
}
