<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Users\UserRepositoryInterface;
use App\Policies\UserPolicy;
use Auth;
use Gate;

class UserController extends Controller
{
    protected $user;

    public function __construct (UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    public function updateRole(Request $request, $id)
    {
        $this->validate($request, [
            'role_id' => 'required'
        ]);
        $user = $this->user->find($id);
        $this->authorize('updateRole', Auth::user());
        $user->update([
            'role_id' => $request->role_id
        ]);

        return response()->json([
            'message' => config('api.updated')
        ], 200);
    }
}
