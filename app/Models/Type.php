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
}
