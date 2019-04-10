<?php

namespace Pheaks;

use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    protected $table = 'notifies';

    public function to()
    {
        return $this->belongsTo(User::class,'user_to');
    }

    public function from()
    {
        return $this->belongsTo(User::class,'user_from');
    }
}
