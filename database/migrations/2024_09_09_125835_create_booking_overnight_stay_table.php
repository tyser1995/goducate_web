<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingOvernightStayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_overnight_stays', function (Blueprint $table) {
            $table->id();
            $table->integer('created_by_user_id')->default(0)->nullable();
            $table->integer('customer_id')->default(0)->nullable();
            $table->string('email')->nullable();
            $table->string('room_type')->comment('Jungle Huts (6 to 8 persons),Family Room (3 to 5 persons),Hillside Villa (8 to 12 persons),Courtyard Big Room (8 to 10 persons),Courtyard Small Room (2 to 4 persons)')->nullable();
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
        Schema::dropIfExists('booking_overnight_stays');
    }
}
