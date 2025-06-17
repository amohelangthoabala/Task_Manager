<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AuthController extends Controller
{
    use ValidatesRequests;

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    
    /**
     * Authentication Token.
     * 
     * @group Auth Token
     * 
     * If a test user (test@example.com) does not exist, it will be created first.
     * 
     * @response 200 {
     *   "token": "newly-created-test-user-token",
     *   "user": {
     *     "id": 1,
     *     "name": "Test User",
     *     "email": "test@example.com"
     *   }
     * }
     */
    public function generateTestUserToken()
    {
        $user = User::firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'password' => Hash::make('secret'), // fallback password
        ]);

        $token = $user->createToken('testing')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }
    

    /**
     * Register a new user.
     * 
     * @bodyParam name string required User's full name. Example: John Doe
     * @bodyParam email string required User's email address. Example: john@example.com
     * @bodyParam password string required Password (minimum 6 characters). Example: secret123
     * @bodyParam password_confirmation string required Password confirmation. Example: secret123
     *
     * @response 200 {
     *   "user": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "john@example.com"
     *   },
     *   "token": "some-generated-token"
     * }
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $result = $this->authService->register($validated);

        return response()->json($result);
    }

    /**
     * Log in a user and create a token.
     * 
     * @bodyParam email string required User's email address. Example: john@example.com
     * @bodyParam password string required Password. Example: secret123
     *
     * @response 200 {
     *   "user": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "john@example.com"
     *   },
     *   "token": "some-generated-token"
     * }
     * @response 401 {
     *   "message": "Invalid credentials"
     * }
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $result = $this->authService->login($validated);

        return response()->json($result);
    }

    /**
     * Log out the authenticated user (delete current access token).
     * 
     * @authenticated
     *
     * @response 200 {
     *   "message": "Successfully logged out"
     * }
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
