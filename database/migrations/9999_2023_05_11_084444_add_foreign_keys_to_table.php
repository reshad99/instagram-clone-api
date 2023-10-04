<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $tableKeys = [


    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tableKeys as $table => $keys) {
            Schema::table($table, function (Blueprint $table) use ($keys) {
                $table->foreignId($keys['foreignKey'])->nullable()->after($keys['after'])->references($keys['referenceId'])->on($keys['table']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('table', function (Blueprint $table) {
        //     //
        // });
    }
};
