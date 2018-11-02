<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'username' => 'asAdmin',
            'password' => bcrypt('123456'),
            'level' => 1
        ]);

        DB::table('admins')->insert([
            'username' => 'testadmin01',
            'password' => bcrypt('123456'),
        ]);

        DB::table('admins')->insert([
            'username' => 'testadmin02',
            'password' => bcrypt('123456'),
        ]);

        DB::table('admins')->insert([
            'username' => 'testadmin03',
            'password' => bcrypt('123456'),
        ]);

        DB::table('admins')->insert([
            'username' => 'testadmin04',
            'password' => bcrypt('123456'),
        ]);

    }
}
