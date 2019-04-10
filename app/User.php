<?php

namespace Pheaks;

use Illuminate\Foundation\Auth\User as AuthenticatableUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Carbon\Carbon;

class User extends AuthenticatableUser implements Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 
        'first_name',
        'first_name',
        'last_name',
        'birthday', 
        'email', 
        'sex', 
        'interest',
        'password',
        'role',
        'language',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAgeAttribute()
    {
        $id = $this->id;
        $birth_time = strtotime($this->birthday);

        return Carbon::createFromDate(date('Y', $birth_time), date('m', $birth_time), date('d', $birth_time))->age;
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = \Hash::make($password);
    }

    /*public function getProfileAttribute()
    {
        $profile = Profiles::find(['user_id'=>$this->id]);

        return $profile[0];
    }*/

    /**
     * Get the profile record associated with the user.
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'object');
    }

    public function profile()
    {
        return $this->hasOne('Pheaks\Profiles');
    }

    public function admin()
    {
        return $this->role=='admin'||$this->role=='s_admin';
    }
}
