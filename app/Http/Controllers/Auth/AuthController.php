<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required|in:1,2,3',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);
    
        $token = $user->createToken('api-token')->plainTextToken;
        $resp = [
            'user' => $user, 
            'token' => $token
        ];
        return $this->response($resp);
    }
    
    public function login(Request $request) {
        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        $token = auth()->user()->createToken('api-token')->plainTextToken;
        return $this->response(['user' => auth()->user(), 'token' => $token]);
    }
    
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
    
}
