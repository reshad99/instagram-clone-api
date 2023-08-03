<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $tableKeys = [
        'favorite_addresses' => [
            'foreignKey' => 'address_type_id',
            'after' => 'user_id',
            'table' => 'address_types',
            'referenceId' => 'id'
        ],
        'drivers' => [
            'foreignKey' => 'park_id',
            'after' => 'id',
            'table' => 'parks',
            'referenceId' => 'id',
            'null' => 'nullable'
        ],
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
