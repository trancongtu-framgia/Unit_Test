<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;

class BatchRepository extends EloquentRepository
{
    public function model()
    {
        return \App\Batch::class;
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

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            return response()->json($exception);
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
}
