<?php

use App\Role;
use Illuminate\Database\Seeder;
use App\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_perms = [
            'send-emails',
            'view-records',
            'pay-out',
            'view-payments',
        ];
        $support_perms = [
            'send-emails',
            'view-emails',
        ];
        $finance_perms = [
            'pay-out',
            'view-payments',
        ];

        $super_admin = Permission::all();
        $admin = Permission::whereIn('slug', $admin_perms)->get();
        $finance = Permission::whereIn('slug', $finance_perms)->get();
        $support = Permission::whereIn('slug', $support_perms)->get();

        $super_admin_role = new Role();
        $super_admin_role->slug = 'super-admin';
        $super_admin_role->description = 'Super Admin Role';
        $super_admin_role->save();
        $super_admin_role->permissions()->attach($super_admin);

        $admin_role = new Role();
        $admin_role->slug = 'admin';
        $admin_role->description = 'Admin Role';
        $admin_role->save();
        $admin_role->permissions()->attach($admin);

        $support_role = new Role();
        $support_role->slug = 'support-admin';
        $support_role->description = 'Support Role';
        $support_role->save();
        $support_role->permissions()->attach($support);

        $finance_role = new Role();
        $finance_role->slug = 'finance-admin';
        $finance_role->description = 'Finance Role';
        $finance_role->save();
        $finance_role->permissions()->attach($finance);
    }
}
