<?php

namespace Pheaks;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function chat()
    {
        return $this->belongsTo('Pgeaks\Chat', 'message_id');
    }

    public function from()
    {
        return $this->hasOne(User::class,'id','user_from');
    }

    public function to()
    {
        return $this->hasOne(User::class,'id', 'user_to');
    }
}
