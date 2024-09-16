<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingDayTourTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_day_tours', function (Blueprint $table) {
            $table->id();
            $table->integer('created_by_user_id')->default(0)->nullable();
            $table->integer('customer_id')->default(0)->nullable();
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->string('tour_type')->comment('Team Building,Family Fun and Learning');
            $table->string('group_type')->comment('church,school,corporate,others')->nullable(); //this is for team building
            $table->integer('no_of_persons')->default(0)->nullable();//this is for family
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
        Schema::dropIfExists('booking_day_tours');
    }
}
