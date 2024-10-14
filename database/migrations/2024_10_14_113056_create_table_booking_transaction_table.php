<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBookingTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('created_by_user_id')->default(0)->nullable();
            $table->integer('customer_id')->default(0)->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->longText('address')->nullable();
            $table->string('contact_no')->nullable();
            $table->integer('no_of_adults')->default(0);
            $table->integer('no_of_children')->default(0);
            $table->integer('boooking_status')->comment('0-overnight_stay,1-day_tour,2-place_reservation');
            $table->string('status')->default('')->nullable();
            $table->integer('accomodation_id')->default(0);
            $table->string('accomodation_name')->nullable();
            $table->integer('accomodation_qty')->default(0)->nullable();
            $table->integer('accomodation_taken')->default(0)->nullable();
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
        Schema::dropIfExists('booking_transactions');
    }
}
