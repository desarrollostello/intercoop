<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Photos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id');
            $table->boolean('is_avatar')->default(false);
            $table->string('original');
            $table->string('large');
            $table->string('medium');
            $table->string('small');
            /*
             * Privacy -> used to set privacy
             * 0 = only me
             * 1 = public
             * 2 = only contacts
             * 3-4 = other options
             * */
            $table->enum('privacy', [0,1,2,3,4]);
            $table->enum('status', [0,1,2,3,4]);
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
        Schema::drop('photos');
    }
}
