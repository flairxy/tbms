<?php

use App\BusinessRole;
use App\Role;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'send-emails',
            'view-emails',
            'view-records',
            'pay-out',
            'view-payments',

            'create-user',
            'create-plan',

            'edit-user',
            'edit-plan',

            'update-plan',
            'update-user',

            'delete-plan',
            'delete-user',
        ];

        foreach ($permissions as $permission) {
            $word = explode('-', $permission);
            \App\Permission::firstOrCreate([
                'slug' => $permission,
                'description' => implode('s ', $word)
            ]);
        }

    }
}
