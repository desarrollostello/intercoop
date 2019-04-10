<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Messages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_from');
            $table->integer('user_to');
            $table->string('message');
            $table->integer('photo_id')->nallable();
            $table->enum('type', [0,1,2]); // Type 0=text, 1=image, 3=other
            $table->enum('status', [0,1,2,3])->default(1); // Status 0=no viewed, 1=viewed, 2-3=other
            $table->boolean('viewed')->default(false);
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
        Schema::drop('messages');
    }
}
