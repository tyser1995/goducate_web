<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingPlaceReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_place_reservations', function (Blueprint $table) {
            $table->id();
            $table->integer('created_by_user_id')->default(0)->nullable();
            $table->integer('customer_id')->default(0)->nullable();
            $table->string('email')->nullable();
            $table->string('room_type')->comment('Board Room,Function Hall,Basketball Gym,Cottages,Small Huts')->nullable();
            $table->integer('no_of_cottages')->default(0)->nullable();//
            $table->integer('no_of_persons')->default(0)->nullable();//
            $table->datetime('checkin_date')->nullable();
            $table->datetime('checkout_date')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('booking_place_reservations');
    }
}
