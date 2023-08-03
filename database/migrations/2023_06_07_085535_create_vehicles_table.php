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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->bigInteger('mileage');
            $table->integer('engine');
            $table->foreignId('manufacturer_id')->references('id')->on('common_data');
            $table->foreignId('model_id')->references('id')->on('vehicle_models');
            $table->foreignId('ban_id')->references('id')->on('common_data');
            $table->foreignId('color_id')->references('id')->on('common_data');
            $table->integer('seat_count');
            $table->string('plate_number');
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
        Schema::dropIfExists('vehicles');
    }
};
