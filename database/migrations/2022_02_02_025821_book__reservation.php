<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BookReservation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rented_book', function (Blueprint $table) {
            $table->bigIncrements('id')->primaryKey();
            $table->unsignedBigInteger('u_id');
            $table->unsignedBigInteger('b_id');
            $table->dateTime('rent_date');
            $table->dateTime('return_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rented_book');
    }
}
