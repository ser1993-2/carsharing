<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('car_id');
            $table->integer('total_cost')->default(0);
            $table->dateTime('start')->nullable();
            $table->dateTime('finish')->nullable();
            $table->timestamps();
        });

        Schema::table('trips', function (Blueprint $table) {
            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('car_id')->on('cars')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
};
