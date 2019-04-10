<?php

namespace Pheaks;

use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
    protected $table = "profiles";
    protected $fillable = [
        'user_id',
        'avatar_photo_id',
        'public_folder',
        'description',
        'zodiac_sign',
        'height',
        'complexion',
        'civil_status',
        'children',
        'sex_preference',
        'education',
        'smoking',
        'drink',
        'laboral_sector',
        'salary',
        'contry',
        'region',
        'citie'
    ];

    public function avatar()
    {
        return $this->hasOne('Pheaks\Photo', 'id', 'avatar_photo_id');
    }
}
