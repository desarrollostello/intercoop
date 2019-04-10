<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Notifies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifies', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_from');
            $table->integer('user_to');
            //Staus 0 = no viewed, 1 = viewed, 2-3-4 = others
            $table->enum('status', [0,1,2,3,4])->nullable();
            /*
             *          Type
             * 0 = Someone has accectp your request
             * 1 = Someone has added you
             * 2 = Someone has sent you a heart
             * 3 = He likes someone
             * 4 = Someone likes your photo
             * 5 = Someone commented on your photo
             * 6 = Someone has commented on your state
             * 7 = Someone likes your state
             * 8 = Visit your profile
             * 9 = other
             * */
            $table->boolean('viewed')->default(false);
            $table->enum('type', [1,2,3,4,5,6,7,8,9]);
            /*
             *      Object
             * It used to join to the ID
             * of another user or the id
             * of the table Contacts
             *  */
            $table->integer('object');
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
        Schema::drop('notifies');
    }
}
