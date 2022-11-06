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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_brand_id');
            $table->unsignedBigInteger('rate_id');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_free')->default(true);
            $table->timestamps();
        });

        Schema::table('cars', function (Blueprint $table) {
           $table->foreign('car_brand_id')->on('car_brands')->references('id');
           $table->foreign('rate_id')->on('rates')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
};
