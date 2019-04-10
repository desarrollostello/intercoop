<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Profiles extends Migration
{

    /**
     * Class Constructor
     */
    public function __construct()
    {
        
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('profiles', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unique();
            $table->integer('avatar_photo_id');
            $table->string('public_folder')->nullable();
            $table->string('description')->nullable();
            $table->string('zodiac_sign')->nullable();
            $table->string('height')->nullable();
            $table->string('complexion')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('children')->nullable();
            /*
             * Sex preference - usado para indentificar las preferencias
             * otros usuarios y hacerlo coninicidir
             * f = female, m = male, b = bisexual, a = all, o = other
             * */
            $table->enum('sex_preference',['f','m','b','o','a'])->nullable();
            $table->string('education')->nullable();
            $table->string('smoking')->nullable();
            $table->string('drink')->nullable();
            $table->string('laboral_sector')->nullable();
            $table->string('salary')->nullable();
            $table->string('country');
            $table->string('citie');
            $table->string('region');
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
        Schema::drop('profiles');
    }
}
