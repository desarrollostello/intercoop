<?php

namespace Pheaks;

use Illuminate\Database\Eloquent\Model;

class SocialConnect extends Model
{
    protected $table = 'socialconnect';

    protected $fillable = [
        'user_id','social_name','social_id'
    ];
}
