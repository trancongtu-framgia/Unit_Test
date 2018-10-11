<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    protected $guarded = ['id'];

    public function month()
    {
        return $this->belongsTo('App\Month');
    }
}
