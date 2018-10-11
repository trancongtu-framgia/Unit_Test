<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DayRepository extends EloquentRepository
{
    public function model()
    {
        return \App\Day::class;
    }

    public function thisMonth($month)
    {
        return $this->model->select(
                DB::raw(
                    'days.id, 
                    days.day, 
                    days.status, 
                    days.dayofweek, 
                    months.month, 
                    months.user_id, 
                    months.year'
                )
            )->join('months', 'days.month_id', 'months.id')
            ->where('months.month', '=', $month)
            ->orderBy(DB::raw('months.year, days.day'))
            ->get();
    }
}
