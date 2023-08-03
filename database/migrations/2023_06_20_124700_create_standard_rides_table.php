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
        Schema::create('standard_rides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('standard_orders');
            $table->decimal('from_latitude');
            $table->decimal('from_longitude');
            $table->decimal('to_latitude');
            $table->decimal('to_longitude');
            $table->double('price');
            $table->decimal('distance');
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
        Schema::dropIfExists('standard_rides');
    }
};
