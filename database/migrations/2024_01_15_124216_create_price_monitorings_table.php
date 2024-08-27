<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceMonitoringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_monitorings', function (Blueprint $table) {
            $table->id();
            $table->integer('created_by_user_id');
            $table->string('commodities_item');
            $table->string('commodities_type');
            $table->string('commodities_size');
            $table->decimal('price', 8, 2)->default(0);
            $table->string('attachment')->nullable();
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
        Schema::dropIfExists('price_monitorings');
    }
}
