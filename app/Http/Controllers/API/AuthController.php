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
        $user = User::create([
            'PERD_EMER'     => $request->PERD_EMER,
            'PERD_MBIEMER'  => $request->PERD_MBIEMER,
            'PERD_EMAIL'    => $request->PERD_EMAIL,
            'PERD_FJKALIM'  => $request->PERD_FJKALIM, // hashed automatically via cast
            'PERD_TIPI'     => $request->PERD_TIPI,
            'PERD_AKTIV'    => true,
        ]);

        $token = $user->createToken(
            'auth_token',
            ['*'],
            now()->addMinutes(config('sanctum.expiration'))
        )->plainTextToken;

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
        // 'password' is the special key Auth::attempt uses for credential checking;
        // it is validated against $user->getAuthPassword() which returns PERD_FJKALIM.
        if (!Auth::attempt([
            'PERD_EMAIL' => $request->PERD_EMAIL,
            'password'   => $request->PERD_FJKALIM,
        ])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
                'data'    => null,
            ], 401);
        }

        $user = Auth::user();

        // Revoke all previous tokens so only one session is active at a time
        $user->tokens()->delete();

        $token = $user->createToken(
            'auth_token',
            ['*'],
            now()->addMinutes(config('sanctum.expiration'))
        )->plainTextToken;

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
            'id'          => $user->PERD_ID,
            'first_name'  => $user->PERD_EMER,
            'last_name'   => $user->PERD_MBIEMER,
            'email'       => $user->PERD_EMAIL,
            'tipi'        => $user->PERD_TIPI,
            'is_active'   => $user->PERD_AKTIV,
        ];
    }
}
