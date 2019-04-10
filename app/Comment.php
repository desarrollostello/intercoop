<?php

namespace Pheaks;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id','object_id','object_type','comment','type','file_id'];

    public function object()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('Pheaks\User');
    }
}
