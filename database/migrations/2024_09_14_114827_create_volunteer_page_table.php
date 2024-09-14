<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteerPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
            $table->integer('created_by_user_id')->default(0)->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->integer('age')->default(0)->nullable();
            $table->longText('address')->nullable();
            $table->date('birthday')->nullable();
            $table->string('church_name')->nullable();
            $table->string('pastor_name')->nullable();
            $table->longText('pastor_recommendation')->nullable();
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
        Schema::dropIfExists('volunteers');
    }
}
