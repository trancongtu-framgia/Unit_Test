<?php
    
namespace App\Repositories\Users;

use App\Repositories\EloquentRepository;

class UserEloquentRepository extends EloquentRepository implements UserRepositoryInterface
{
    public function model()
    {
        return \App\User::class;
    }

    public function getUser($search, $role)
    {
        if (strlen($role) > 0) {
            $this->model = $this->model->where('role_id', $role);
        }

        return $this->model->where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        })
        ->paginate(config('api.paginate'));
    }
}
