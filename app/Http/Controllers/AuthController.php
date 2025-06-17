<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * Register a new user.
 *
 * @bodyParam name string required The user's name.
 * @bodyParam email string required The user's email.
 * @bodyParam password string required The password (min 6).
 * @bodyParam password_confirmation string required Must match the password.
 */

class AuthController extends Controller
{
    protected $authService;
    use ValidatesRequests;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
  
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $result = $this->authService->register($request->all());

        return response()->json($result);
    }
  
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $result = $this->authService->login($request->all());

        return response()->json($result);
    }
/**
 * @authenticated
 */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}