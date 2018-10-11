<?php
    
namespace App\Repositories\Roles;

use App\Repositories\EloquentRepository;

class RoleEloquentRepository extends EloquentRepository implements RoleRepositoryInterface
{
    public function model ()
    {
        return \App\Role::class;
    }
}
