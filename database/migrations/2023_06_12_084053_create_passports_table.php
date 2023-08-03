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
        Schema::create('passports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->unique()->references('id')->on('drivers');
            $table->string('doc_serial_no')->unique()->nullable();
            $table->string('doc_fin')->unique()->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->foreignId('country_id')->nullable()->references('id')->on('common_data'); 
            $table->date('given_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('issued_by');
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
        Schema::dropIfExists('passports');
    }
};
