<?php

namespace Pheaks;

use Illuminate\Database\Eloquent\Model;

class Newsfeed extends Model
{
    protected $table = "newsfeed";

    protected $fillable = [
        "user_id","type","status","object"
    ];

    public function user(){
        return $this->hasOne(User::class, 'user_id');
    }

    /*
     * public function comment(){
     *      return $this->hasOne('Pheaks\Comment');
     * }
     * */

    public function photo()
    {
        return $this->hasOne('Pheaks\Photo');
    }

    public function profile()
    {
        return $this->hasOne('Pheaks\Profiles');
    }
}
