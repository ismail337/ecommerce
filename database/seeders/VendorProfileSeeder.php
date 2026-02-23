<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vendor;

class VendorProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user                = User::where('email', 'admin@example.com')->first();
        $vendor              = new Vendor();
        $vendor->banner      = 'uploads/banner/1223.jpg';
        $vendor->shop_name   = 'Admin Shop';
        $vendor->phone       = '12321312';
        $vendor->email       = 'admin@gmail.com';
        $vendor->address     = 'Usa';
        $vendor->description = 'shop description';
        $vendor->user_id     = $user->id;
        $vendor->save();
    }
}