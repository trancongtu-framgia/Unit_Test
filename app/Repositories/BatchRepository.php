<?php

namespace App\Repositories;

use App\Day;
use App\User;
use App\Batch;
use App\Month;
use Exception;
use App\DayMonth;
use App\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BatchRepository extends EloquentRepository
{
    public function model()
    {
        return \App\Batch::class;
    }

    public function addDayMonth($batch)
    {
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
                'batch_id' => $batch->id,
                'month' => $month,
                'year' => $year
            ]);

            $num_of_days = $month !== $stop_month
                            || $year !== $stop_year ? cal_days_in_month(CAL_GREGORIAN, $month, $year) : $stop_day;

            $day_ids = Day::whereBetween('day', [$start_day, $num_of_days])->pluck('id');

            $created_month->days()->sync($day_ids);

            $start_day = 1;
            $month++;
        }
    }
    
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $batch = $this->model->count();
            $data = array_merge(
                ['batch' => ++$batch],
                $data
            );
            $ids = $data['subject_ids'];
            unset($data['subject_ids']); // remove subject_ids in data
            $batch = $this->model->create($data);
            $batch->subjects()->sync($ids);

            $this->addDayMonth($batch);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            return $exception;
        }

        return response()->json(['message' => config('api.create')]);
    }

    public function update(array $data, $id)
    {
        DB::beginTransaction();
        try {
            $batch = Batch::findOrFail($id);
            $ids = $data['subject_ids'];
            unset($data['subject_ids']); // remove subject_ids in data
            $batch->update($data);
            $batch->subjects()->sync($ids);

            DB::commit();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(['message' => config('api.notfound')]);
        } catch (Exception $exception) {
            DB::rollBack();

            return response()->json($exception);
        }

        return response()->json(['message' => config('api.update')]);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $batch = Batch::findOrFail($id);
            $users = $batch->users()->pluck('id');
            Schedule::whereIn('user_id', $users)->delete();
            User::whereIn('id', $users)->delete();
            $months = $batch->months()->pluck('id');
            DayMonth::whereIn('month_id', $months)->delete();
            Month::whereIn('id', $months)->delete();
            Batch::destroy($id);

            DB::commit();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(['message' => config('api.notfound')]);
        } catch (Exception $exception) {
            DB::rollBack();

            return $exception;
        }

        return response()->json(['message' => config('api.delete')]);
    }
}
