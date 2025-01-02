<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccomodationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accomodations', function (Blueprint $table) {
            $table->id();
            $table->integer('created_by_user_id')->default(0)->nullable();
            $table->string('bookig_status')->nullable();
            $table->string('type')->nullable();
            $table->integer('qty')->default(1)->nullable();
            $table->string('tour_type')->comment('for day tour')->nullable();
            $table->string('group_type')->comment('for day tour')->nullable();
            $table->decimal('amount', 15, 2)->default(0);
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
        Schema::dropIfExists('accomodations');
    }
}
