<?php

namespace App\Repositories\Subject;

use App\Repositories\EloquentRepository;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Subject;

class SubjectEloquentRepository extends EloquentRepository implements SubjectRepositoryInterface
{
    public function model()
    {
        return Subject::class;
    }

    public function getNameSubject ()
    {
        return $this->model->select('name')->get();
    }
}
