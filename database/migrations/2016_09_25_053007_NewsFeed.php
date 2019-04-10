<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewsFeed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsfeed', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id');
            $table->enum('type', [0,1,2,3,4]); //Type 0=comment, 1=photo, 2=avatar, 3-4=other
            $table->enum('status', [0,1,2,3]); //Status 0=invisible, 1=visible, 2=deleted, 3=other
            $table->integer('object'); //Object is joining to comment, photo or avatar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('newsfeed');
    }
}
