<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create a Warehouse Admin
        Admin::create([
            'name' => 'Admin Warehouse',
            'email' => 'warehouse1@example.com',
            'password' => Hash::make('password123'),
            'role' => 'warehouse',
        ]);
        // password sa staff staffpassword123
    }
}

