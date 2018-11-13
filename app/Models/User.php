<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'batch_id',
        'school',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function scopeCreateUser($query, $user)
    {
        $newUser = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'school' => $user->school,
            'role_id' => $user->role_id,
            'batch_id' => $user->batch_id,
            'password' => bcrypt($user->password),
        ]);

        return $newUser;
    }

    public function reports()
    {
        return $this->hasMany('App\Report');
    }

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function notTrainee()
    {
        return $this->role->name !== config('api.trainee');
    }
    
    public function canCreateReport()
    {
        $role = $this->role;

        return $role->name !== config('api.trainer') && $role->name !== config('api.admin');
    }

    public function subjects()
    {
        return $this->belongsToMany('App\Subject', 'reports');
    }
    
    public function batch()
    {
        return $this->belongsTo('App\Batch');
    }

    public function dayMonths()
    {
        return $this->belongsToMany('App\DayMonth', 'schedules', 'user_id', 'day_month_id')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    public function schedules()
    {
        return $this->hasMany('App\Schedules');
    }
    
    public function isAdmin()
    {
        $role = $this->role()->where('name', config('api.isAdmin'))->exists();

        if ($role) {
            return true;
        }

        return false;
    }
}
