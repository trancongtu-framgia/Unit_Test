<?php

namespace App\Repositories;

use App\Subject;
use Illuminate\Support\Facades\DB;

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

    public function getReportsBySubjectID($subject_id, $user_id)
    {
        $this->makeModel();

        return $this->model
            ->select('reports.*', 'reviews.id as review_id', 'reviews.content as review')
            ->leftJoin('reviews', 'reports.id', 'reviews.report_id')
            ->where('reports.user_id', $user_id)
            ->where('subject_id', $subject_id)
            ->get()->toArray();
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

    public function getReportsGroupBySubject($user_id)
    {
        $subjects = Subject::orderBy('name')->pluck('id');
        $result = [];
        foreach ($subjects as $id) {
            $this->makeModel();
            $data = $this->getReportsBySubjectID($id, $user_id);
            $result = array_merge($result, [$data]);
        }

        return $result;
    }
}
