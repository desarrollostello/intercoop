<?php

namespace Pheaks;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = "photos";

    protected $fillable = [
        'user_id', 'is_avatar', 'original', 'large', 'medium','small','status','privacy'
    ];

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
        return $this->belongsTo(User::class, 'user_id');
    }
}
