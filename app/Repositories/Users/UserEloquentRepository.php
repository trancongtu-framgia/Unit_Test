<?php
    
namespace App\Repositories\Users;

use App\Repositories\EloquentRepository;

class UserEloquentRepository extends EloquentRepository implements UserRepositoryInterface
{
    public function model ()
    {
        return \App\User::class;
    }
}
