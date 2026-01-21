<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name'     => 'Admin User',
                'username' => 'adminuser',
                'phone'    => '1234567890',
                'email'    => 'admin@example.com',
                'role'     => 'admin',
                'status'   => 'active',
                'password' => bcrypt('password'),
            ],
            [
                'name'     => 'User',
                'username' => 'user',
                'phone'    => '0987654321',
                'email'    => 'user@example.com',
                'role'     => 'user',
                'status'   => 'active',
                'password' => bcrypt('password'),
            ],
            [
                'name'     => 'Vendor User',
                'username' => 'vendoruser',
                'phone'    => '1122334455',
                'email'    => 'vendor@example.com',
                'role'     => 'vendor',
                'status'   => 'active',
                'password' => bcrypt('password'),
            ],
        ]);
    }
}
