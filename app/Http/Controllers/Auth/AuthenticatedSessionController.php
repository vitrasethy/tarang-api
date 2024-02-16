<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use \Illuminate\Http\JsonResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $token = $request->user()->createToken('token-name')->accessToken;

        return response()->json([
            'token' => $token,
        ]);
        /**
         * $response = Http::asForm()->post('http://passport-app.test/oauth/token', [
         * 'grant_type' => 'refresh_token',
         * 'refresh_token' => 'the-refresh-token',
         * 'client_id' => 2,
         * 'client_secret' => 'bKjXy7X2P5hEpJZ4ZzU4Lql0O0wRrV9o9FA6UrdG',
         * 'scope' => '',
         * ]);
         *
         * return $response->json();
         */
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        $request->user()->token()->revoke();

        return \response()->noContent();
    }
}
