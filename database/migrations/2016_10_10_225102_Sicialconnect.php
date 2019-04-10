<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sicialconnect extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socialconnect', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id');
            $table->string('social_name');
            $table->string('social_id')->unique();
            $table->boolean('register_used')->default(false);
            /*$table->string('_id', 100);
            $table->string('_id', 100);
            $table->string('_id', 100);*/
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
        Schema::drop('socialconnect');
    }
}
