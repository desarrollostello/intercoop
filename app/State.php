<?php

namespace Pheaks;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['user_id','type','state','photo_id','privacy','tags','from_ip_addr','status'];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'object');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'object');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
