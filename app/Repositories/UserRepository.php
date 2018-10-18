<?php

namespace App\Repositories;

use App\Day;
use App\Month;
use App\DayMonth;
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
            $month_ids = Month::where('batch_id', $user->batch_id)->get()->pluck('id');
            $ids = DayMonth::whereIn('month_id', $month_ids)->get()->pluck('id');
            $user->dayMonths()->attach($ids, ['status' => config('api.default.status')]);

            DB::commit();

            return response()->json(['message' => config('api.create')]);
        } catch (Exception $exception) {
            DB::rollback();

            return response()->json($exception);
        }
    }
}
