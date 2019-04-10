<?php

namespace Pheaks;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $fillable = [
        'country',
        'region',
        'region',
        'name',
        'latitude',
        'longitude',
    ];
}
