<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\User as UserResource;

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

    public function login ()
    {

    }
}
