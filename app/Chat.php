<?php

namespace Pheaks;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    public function message()
    {
        return $this->hasMany('Pheaks\Message', 'chat_id');
    }
}
