<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $guarded = ['id'];

    public function batches()
    {
        return $this->hasMany('App\Batch');
    }

    public function scopeUpdateType($query, $data, $id)
    {
        $type = Type::findOrFail($id);
        $type->update($data);

        return response()->json(['message' => config('api.update')]);
    }
}
