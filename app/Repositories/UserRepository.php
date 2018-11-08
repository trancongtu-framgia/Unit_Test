<?php

namespace App\Repositories;

use App\Day;
use App\Batch;
use App\Month;
use App\Report;
use App\Subject;
use App\DayMonth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserRepository extends EloquentRepository
{
    public function model()
    {
        return \App\User::class;
    }

    public function getAllTrainee($id)
    {
        $result = $this->model
                    ->whereIn(
                        'role_id',
                        DB::table('roles')
                        ->select('id')
                        ->where('name', '=', config('api.trainee'))
                    );
        if (func_num_args() > 0) {
            $result = $result->where('batch_id', $id);
        }

        return $result->get();
    }

    public function createTrainee(array $data)
    {
        DB::beginTransaction();
        try {
            $user = $this->model->create($data);
            $month_ids = Month::where('batch_id', $user->batch_id)->get()->pluck('id');
            $ids = DayMonth::whereIn('month_id', $month_ids)->get()->pluck('id');
            $user->dayMonths()->attach($ids, ['status' => config('api.default.status')]);

            $batch = Batch::findOrFail($data['batch_id']);

            $subjects = $batch->subjects;

            foreach ($subjects as $subject) {
                for ($i = 1; $i <= $subject->day; $i++) {
                    Report::create([
                        'user_id' => $user->id,
                        'subject_id' => $subject->id,
                        'day' => $i
                    ]);
                }
            }

            DB::commit();

            return response()->json(['message' => config('api.create')]);
        } catch (Exception $exception) {
            DB::rollback();

            return response()->json($exception);
        }
    }
}
