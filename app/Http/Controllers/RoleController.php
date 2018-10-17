<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Roles\RoleRepositoryInterface;
use App\Http\Resources\Role as RoleResource;
use Auth;

class RoleController extends Controller
{
    protected $role;
    public function __construct (RoleRepositoryInterface $role)
    {
        $this->role = $role;
    }

    public function index ()
    {
        $roles = $this->role->getAll();

        return RoleResource::collection($roles);
    }
}
