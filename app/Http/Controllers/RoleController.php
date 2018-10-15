<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Roles\RoleRepositoryInterface;
use Auth;

class RoleController extends Controller
{
    protected $role;
    public function __construct (RoleRepositoryInterface $role)
    {
        $this->role = $role;
    }
}
