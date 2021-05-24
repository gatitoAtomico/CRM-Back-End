<?php

use App\Roles;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        User::create(array('first_name' => 'George','last_name' =>  'Petrou', 'avatar' => 'default.jpg', 'email' => 'admin@admin.com','password' => Hash::make('1234')));
        User::create(array('first_name' => 'Nick','last_name' =>  'Jones', 'avatar' => 'default.jpg', 'email' => 'nick@gmail.com','password' => Hash::make('1235')));
        User::create(array('first_name' => 'Ryan','last_name' =>  'Giggs', 'avatar' => 'default.jpg', 'email' => 'giggs@gmail.com','password' => Hash::make('1236')));
        Roles::create(array('role' => 'admin','user_id' => 1));
        Roles::create(array('role' => 'user','user_id' => 2));
        Roles::create(array('role' => 'user','user_id' => 3));
    }
}


