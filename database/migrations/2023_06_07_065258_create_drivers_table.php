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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->enum('gender', ['male', 'female']);
            $table->boolean('status')->default(1);
            $table->boolean('available')->default(0);
            $table->unsignedTinyInteger('rating');
            $table->date('birth_date');
            $table->string('full_name');
            $table->string('phone');
            $table->string('email');
            $table->string('password');
            $table->string('fcm_token');
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
        Schema::dropIfExists('drivers');
    }
};
