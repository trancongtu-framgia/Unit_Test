<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    protected $guarded = ['id'];

    public function batches()
    {
        return $this->hasMany('App\Batch');
    }

    public function scopeUpdateWorkspace($query, $id, $data)
    {
        $workspace = Workspace::findOrFail($id);
        $workspace->update($data);
    }
}
