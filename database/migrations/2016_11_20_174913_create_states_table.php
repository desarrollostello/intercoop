<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            //Type is used for locate type of post
            //0=text, 1=text with image, 2,3,4=Other option for future
            $table->enum('type',[0,1,2,3,4]);
            $table->string('state');
            $table->integer('photo_id')->nullable();
            $table->enum('privacy', [0,1,2,3,4]);
            $table->string('tags');
            $table->string('from_ip_address')->nullable();
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
        Schema::dropIfExists('states');
    }
}
