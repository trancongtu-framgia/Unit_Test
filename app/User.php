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
        'school'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
}
