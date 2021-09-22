<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;


class AuthController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    // vaildate user credential info and return jwt token

    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    // regresh - create new token
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    // get authenticated user info
    public function userProfile() {
        return response()->json(auth()->user());
    }

    // create new jwt token
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'user' => auth()->user()
        ]);
    }

}
