<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use Auth;
use App\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            'school' => 'required|string|max:191',
        ]);
        $newUser = User::createUser($request);

        return new UserResource($newUser);
    }

    public function login (Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|min:3',
            'password' => 'required|string|min:3',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {

            return response()->json([
                'message' => config('api.unauthorized')
            ]);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    public function logout (Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => config('api.logout.success')
        ]);
    }

    public function currentUser(Request $request)
    {
        return response()->json($request->user());
    }
}
