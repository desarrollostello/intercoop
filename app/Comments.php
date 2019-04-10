<?php

namespace Pheaks;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    public function photo()
    {
        return $this->belongsTo('Pheaks\Photo');
    }

    public function post()
    {
        return $this->belongsTo('Pheaks\post');
    }
}
