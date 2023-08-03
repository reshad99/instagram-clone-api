<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =
        [
            [
                'Kassa sil',
                'cash-register.destroy',
                'web'
            ],
        ];

        foreach ($data as $key => $item) {
            $permission = new Permission();
            $permission->title = $item[0];
            $permission->name = $item[1];
            $permission->guard_name = $item[2];
            $permission->save();
        }
    }
}
