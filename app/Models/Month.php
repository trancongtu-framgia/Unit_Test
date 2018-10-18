<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    protected $guarded = ['id'];

    public function days()
    {
        return $this->belongsToMany('App\Day')->withTimestamps();
    }

    public function batch()
    {
        return $this->belongsTo('App\Batch');
    }
}
