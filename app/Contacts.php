<?php

namespace Pheaks;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    protected $table = 'contacts';

    protected $fillable = [
        'user_from','user_to','status','locked'
    ];

    public function user_f()
    {
        return $this->hasOne(User::class, 'id', 'user_from');
    }

    public function user_t()
    {
        return $this->hasOne(User::class, 'id', 'user_to');
    }

    public function profile()
    {
        return $this->hasOne(Profiles::class);
    }
}
