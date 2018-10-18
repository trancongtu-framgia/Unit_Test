<?php

use App\Role;
use App\Http\Resources\Role as RoleResource;

function roleIsTrainee()
{
    $roleIsTrainee = Role::whereName('Trainee')->firstOrFail();
    
    return new RoleResource($roleIsTrainee);
}
