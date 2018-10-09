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
}
