<?php

namespace Pheaks;

use Illuminate\Database\Eloquent\Model;

class Hearts extends Model
{
    protected $table = 'hearts';

    protected $fillable = [
        'user_from','user_to','status','viewed'
    ];
}
