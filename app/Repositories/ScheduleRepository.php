<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ScheduleRepository extends EloquentRepository
{
    public function model()
    {
        return \App\Schedule::class;
    }

    public function getUserByDate($day_month_id, $status)
    {
        $this->makeModel();

        return $this->model->select(['users.*', 'schedules.id as schedules'])
                ->from(DB::raw('users, schedules'))
                ->where('schedules.day_month_id', $day_month_id)
                ->where('users.id', DB::raw('schedules.user_id'))
                ->where('schedules.status', '=', $status)
                ->get();
    }

    public function showSchedule($id)
    {
        $this->makeModel();

        return $this->model
            ->join(
                DB::raw('(select day_month.id, month, day, year
                                from day_month
                                inner join days on day_id = days.id
                                inner join months on month_id = months.id
                        ) as dayMonth'),
                'day_month_id',
                'dayMonth.id'
            )
            ->where('user_id', $id)->get();
    }

    public function traineeSchedule($id)
    {
        $this->makeModel();

        return $this->model
            ->select(DB::raw('schedules.id, day_month_id, day, month, year, status, count(*) as count'))
            ->join(
                DB::raw('(select day_month.id, day, month, year
                        from day_month
                        inner join days on day_id = days.id
                        inner join months on month_id = months.id
                        where batch_id =' . $id .
                ') as dayMonth'),
                'day_month_id',
                'dayMonth.id'
            )
            ->where('status', '>', '0')
            ->groupBy('status', 'year', 'month', 'day')
            ->orderBy('year')
            ->orderBy('month')
            ->orderBy('day')
            ->get();
    }

    public function findByDate($date, $id)
    {
        $this->makeModel();
        $day = date('j', strtotime($date));
        $month = date('n', strtotime($date));
        $year = date('Y', strtotime($date));

        return $this->model->where('user_id', $id)
                ->whereIn(
                    'day_month_id',
                    DB::table('day_month')
                            ->join('days', 'day_id', 'days.id')
                            ->join('months', 'month_id', 'months.id')
                            ->select('day_month.id')
                            ->where([
                                'days.day' => $day,
                                'months.month' => $month,
                                'months.year' => $year
                            ])
                        )->first();
    }
}
