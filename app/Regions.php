<?php

namespace Pheaks;

use Illuminate\Database\Eloquent\Model;

class Regions extends Model
{
    public $fillable = [
        'country',
        'code',
        'name',
        'latitude',
        'longitude',
        'cities',
    ];
}
