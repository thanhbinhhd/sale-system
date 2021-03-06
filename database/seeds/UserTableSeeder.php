<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'User01',
            'email' => 'quanghoang4334@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        DB::table('users')->insert([
            'name' => 'User02',
            'email' => 'quanghm@haposoft.com',
            'password' => bcrypt('123456'),
        ]);

        DB::table('users')->insert([
            'name' => 'TestUser',
            'email' => 'user@user.com',
            'avatar' => '/admin/images/avatar.jpg',
            'password' => bcrypt('123456'),
            'email_verified_at' => date("Y-m-d H:i:s"),
        ]);
        factory(\App\Model\User::class, 10)->create();
    }
}
