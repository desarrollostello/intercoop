<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_name')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birthday');
            $table->string('email')->unique();
            $table->enum('sex', ['f','m','b']);
            $table->enum('interest', ['f','m','b']);
            $table->string('password')->nullable();
            $table->enum('role', ['s_admin','admin','user'])->default('user'); //Role s_admin=super admin, admin=admin, user=user
            $table->string('language',50);
            $table->enum('status', [0,1,2,3])->default(1);
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
