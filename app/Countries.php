<?php

namespace Pheaks;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    protected $table = "countries";
    protected $fillable = [
        'iso',
        'name',
        'nicename',
        'iso3',
        'numcode',
        'phonecode',
    ];
}
