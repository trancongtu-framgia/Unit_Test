<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $guarded = ['id'];

    public function batches()
    {
        return $this->belongsToMany('App\Batch');
    }
}
