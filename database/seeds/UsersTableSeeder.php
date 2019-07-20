<?php

use Faker\Factory;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = \App\Role::where('slug', 'super-admin')->first();
        $user = new \App\User();
        $user->username = 'super-admin';
        $user->email = 'superadmin@localhost';
        $user->role = $role->id;
        $user->password = bcrypt('secret');
        $user->save();
        $user->roles()->attach($role);

    }
}
