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
        Schema::create('standard_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('driver_id')->references('id')->on('drivers');
            $table->foreignId('vehicle_id')->references('id')->on('vehicles');
            $table->double('price');
            $table->double('tip')->default('0.00');
            $table->enum('payment_method', ['cash', 'non-cash']);
            $table->time('waiting_duration')->nullable();
            $table->time('ride_duration')->nullable();
            $table->unsignedTinyInteger('status')->default(0)->comment('{"0": "Sürücü axtarılır", "1": "Sürücü tapıldı", "2": "Sürücü çatdı", "3": "Gediş başladı", "4": "Gediş uğurla başa çatdı", "5": "Gediş ləğv edildi"}');
            $table->unsignedTinyInteger('stars')->nullable();
            $table->text('feedback')->nullable();
            $table->enum('who_rejected', ['customer', 'driver'])->nullable();
            $table->foreignId('reject_cause_id')->nullable()->constrained('common_data');
            $table->text('reject_cause_text')->nullable();
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
        Schema::dropIfExists('standard_rides');
    }
};
