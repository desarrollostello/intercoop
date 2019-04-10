<?php

namespace Pheaks;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = ['user_from','user_to','count_visits'];

    public function to()
    {
        return $this->belongsTo(User::class, 'user_to');
    }

    public function from()
    {
        return $this->belongsTo(User::class, 'user_from');
    }

    public function getUpdatedAttribute()
    {
        return $this->updated_at;
    }
}
