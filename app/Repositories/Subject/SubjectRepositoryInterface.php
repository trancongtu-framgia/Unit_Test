<?php

namespace App\Repositories\Subject;

use App\User;

interface SubjectRepositoryInterface
{
    public function getNameSubject();

    public function getUserSubject($userId);
}
