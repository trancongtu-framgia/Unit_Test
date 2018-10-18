<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ScheduleRepository extends EloquentRepository
{
    public function model()
    {
        return \App\Schedule::class;
    }

    public function showSchedule($id)
    {
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
}
