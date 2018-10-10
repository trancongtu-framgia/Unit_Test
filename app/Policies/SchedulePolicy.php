<?php

namespace App\Policies;

use App\Day;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchedulePolicy
{
    use HandlesAuthorization;

    public function update(User $user, Day $day)
    {
        return $user->id === $day->month->user_id;
    }
}
