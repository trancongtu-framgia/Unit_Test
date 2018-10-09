<?php

namespace App\Repositories;

class ReportRepository extends EloquentRepository
{
    public function model()
    {
        return \App\Report::class;
    }

    public function getReports($search)
    {
        $this->makeModel();

        return $this->model->join('users', 'reports.id', 'users.id')
                    ->where('name', 'Like', '%' . $search . '%')
                    ->orderBy('name')
                    ->select('reports.*', 'users.name', 'users.email', 'users.school')
                    ->paginate(config(10));
    }
}
