<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'));
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
//            return response()->json(['error' => 'Unauthorized: login attempt failed'], 401);
            abort(401, 'Unauthorized: login attempt failed with these credentials');
        }
        $user = auth('api')->user();
        return response()->json(compact('token', 'user'));
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        Log::info(request()->all());
        auth('api')->logout();
        return response()->json(['message' => 'Logged out']);
    }
}
