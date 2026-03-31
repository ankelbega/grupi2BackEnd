<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Register a new user and return a Sanctum token.
     *
     * POST /api/register
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        // Create the user — password is auto-hashed by the User model's cast
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => $request->password,
            'role'       => 'student',
            'is_active'  => true,
        ]);

        // Issue a Sanctum personal access token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
            'data'    => [
                'user'  => $this->userPayload($user),
                'token' => $token,
            ],
        ], 201);
    }

    /**
     * Authenticate a user and return a fresh Sanctum token.
     *
     * POST /api/login
     */
    public function login(LoginRequest $request): JsonResponse
    {
        // Attempt authentication with the provided credentials
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
                'data'    => null,
            ], 401);
        }

        $user = Auth::user();

        // Revoke all previous tokens so only one session is active at a time
        $user->tokens()->delete();

        // Issue a fresh token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data'    => [
                'user'  => $this->userPayload($user),
                'token' => $token,
            ],
        ], 200);
    }

    /**
     * Revoke the current access token (logout).
     *
     * POST /api/logout  (requires auth:sanctum)
     */
    public function logout(Request $request): JsonResponse
    {
        // Delete only the token that was used for this request
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully',
            'data'    => null,
        ], 200);
    }

    /**
     * Return the currently authenticated user's profile.
     *
     * GET /api/me  (requires auth:sanctum)
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'User retrieved',
            'data'    => [
                'user' => $this->userPayload($request->user()),
            ],
        ], 200);
    }

    /**
     * Return a consistent user data shape for API responses.
     * Never includes the password field.
     */
    private function userPayload(User $user): array
    {
        return [
            'id'         => $user->id,
            'first_name' => $user->first_name,
            'last_name'  => $user->last_name,
            'email'      => $user->email,
            'role'       => $user->role,
            'is_active'  => $user->is_active,
        ];
    }
}
