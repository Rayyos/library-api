<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('u_id')->primaryKey();
            $table->string('firstname',255);
            $table->string('lastname',255);
            $table->integer('mobile')->unique();
            $table->string('email',191)->unique();
            $table->tinyInteger('age')->nullable();
            $table->enum('gender', array('m','f','o'))->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('city',255)->nullable();           
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
        Schema::dropIfExists('users');
    }
}
