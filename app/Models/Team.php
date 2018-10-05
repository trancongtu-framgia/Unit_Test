<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $guarded = ['id'];

    public function batches()
    {
        return $this->hasMany('App\Batch');
    }

    public function scopeUpdateTeam($query, $id, $data)
    {
        $team = Team::findOrFail($id);
        $team->update($data);

        return response()->json(['message' => config('api.update')]);
    }
}
