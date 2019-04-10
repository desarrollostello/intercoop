<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Cities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function(Blueprint $table){
            $table->increments('id'); //int (11),
            $table->char('country'); //char (6),
            $table->string('region');
            $table->char('code'); //char (9),
            $table->string('name'); //varchar (150),
            $table->double('latitude'); //double ,
            $table->double('longitude'); //double ,
            $table->integer('cities'); //int (4)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cities');
    }
}
