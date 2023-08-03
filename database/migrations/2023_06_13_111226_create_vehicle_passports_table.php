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
        Schema::create('vehicle_passports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->unique()->references('id')->on('vehicles');
            $table->foreignId('driver_id')->references('id')->on('drivers');
            $table->string('serial_no')->unique()->nullable();
            $table->date('given_date')->nullable();
            $table->date('expiry_date')->nullable();
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
        Schema::dropIfExists('vehicle_passports');
    }
};
