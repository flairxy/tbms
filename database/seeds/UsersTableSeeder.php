<?php

use App\Driver;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $faker = Factory::create();

        $user = new \App\User();
        $user->name = $faker->name;
        $user->email = 'superadmin@localhost';
        $user->role = 1;
        $user->phone = $faker->phoneNumber;
        $user->password = bcrypt('secret');
        $user->save();

        $user = new \App\User();
        $user->name = $faker->name;
        $user->email = 'nonny4014@gmail.com';
        $user->phone = $faker->phoneNumber;
        $user->password = bcrypt('secret');
        $user->save();

        for ($i = 1; $i <= 12; $i++) {
            $user = \App\User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'role' => 2,
                'password' => bcrypt('secret')
            ]);

            Driver::create([
                'user_id' => $user->id,
                'registration_no' => 'UNN/TB/'. $user->id. random_int(10, 1000)
            ]);
        }


        for ($i = 1; $i <= 10; $i++) {
            $user = \App\User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'role' => 0,
                'password' => bcrypt('secret')
            ]);
        }

        $taxi = new \App\Setting();
        $taxi->name = 'taxi';
        $taxi->amount = 350;
        $taxi->save();

        $mini_bus = new \App\Setting();
        $mini_bus->name = 'mini-bus';
        $mini_bus->amount = 500;
        $mini_bus->save();

        $bus = new \App\Setting();
        $bus->name = 'bus';
        $bus->amount = 1000;
        $bus->save();
    }
}
