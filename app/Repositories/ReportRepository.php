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
                    ->paginate(config('paginate'));
    }

    public function getReportsBySubject($search)
    {
        $this->makeModel();

        return $this->model->join('subjects', 'reports.subject_id', 'subjects.id')
                    ->where('reports.subject_id', $search)
                    ->orderBy('reports.id')
                    ->select('reports.*', 'subjects.name')
                    ->get();
    }
}
