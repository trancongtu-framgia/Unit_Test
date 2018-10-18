<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DayMonth extends Model
{
    protected $table = 'day_month';

    public function users()
    {
        return $this->belongsToMany('App\User', 'schedules', 'day_month_id', 'user_id')
                    ->withPivot('status')
                    ->withTimestamps();
    }
}
