<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
// use Illuminate\Auth\SessionGuard::factory;

class UserController extends Controller
{

    function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['login']]);
    }
    
    // public function getUser() {
    //     $user = JWTAuth::parseToken()->authenticate();
    //     $response = [
    //         'status' => 'success',
    //         'data' => $user
    //     ];
    //     return response()->json($response, 200);
    // }

    public function me() {
        return response()->json(auth()->user());
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        $token = null;

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }

        // return response()->json([
        //     'status' => 'success',
        //     'token' => $token,
        
        // ]);

        return $this->respondWithToken($token);
    }

    public function refresh() {
        return $this->respondWithToken(auth('api')->refresh());
    }

    public function logout() {
        auth()->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'User logged out successfully'
        ]);
    }

    public function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'user'         => auth()->user(),
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    
}
