<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

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
}
