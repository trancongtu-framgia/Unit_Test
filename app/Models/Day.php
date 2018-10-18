<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    protected $guarded = ['id'];

    public function months()
    {
        return $this->belongsToMany('App\Month')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot('status');
    }
}
