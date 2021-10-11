<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::insert([
            'first_name' => 'Admin',
            'email' => 'admin@cannabis.com',
            'password' => bcrypt(defaultPass()),
            'user_type' => 1,
            'email_verified_at' => date("Y-m-d H:i:s"),
            'verify_otp' => 1,
            'created_at' => date("Y-m-d H:i:s")
        ]);
    }
}
