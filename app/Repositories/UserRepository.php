<?php

namespace App\Repositories;

use App\Day;
use App\Month;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserRepository extends EloquentRepository
{
    public function model()
    {
        return \App\User::class;
    }

    public function getAllTrainee()
    {
        return $this->model
                    ->whereIn(
                        'role_id',
                        DB::table('roles')
                        ->select('id')
                        ->where('name', '=', config('api.trainee'))
                    )
                    ->paginate(config('api.paginate'));
    }

    public function createTrainee(array $data)
    {
        DB::beginTransaction();
        try {
            $user = $this->model->create($data);

            $batch = $user->batch;
            $start = Carbon::parse($batch->start_day);
            $stop = Carbon::parse($batch->stop_day);
            $diff_month = $start->diffInMonths($stop);

            $start_day = $start->day;
            $month = $start->month;
            $year = $start->year;
            $stop_day = $stop->day;
            $stop_month = $stop->month;
            $stop_year = $stop->year;

            for ($i = 0; $i <= $diff_month; $i++) {
                if ($month >= 12) {
                    $month = 1;
                    $year++;
                }

                $created_month = Month::create([
                    'user_id' => $user->id,
                    'month' => $month,
                    'year' => $year
                ]);

                $num_of_days = $month !== $stop_month
                                || $year !== $stop_year ? cal_days_in_month(CAL_GREGORIAN, $month, $year) : $stop_day;

                for ($j = $start_day; $j <= $num_of_days; $j++) {
                    $dayofweek = Carbon::create($year, $month, $j)->dayOfWeek;
                    Day::create([
                        'day' => $j,
                        'status' => 0,
                        'month_id' => $created_month->id,
                        'dayofweek' => $dayofweek
                    ]);
                }
                $start_day = 1;
                $month++;
            }

            DB::commit();

            return response()->json(['message' => config('api.create')]);
        } catch (Exception $exception) {
            DB::rollback();

            return response()->json($exception);
        }
    }
}
