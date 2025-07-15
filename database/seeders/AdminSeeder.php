<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create a Admin
        // Create a Warehouse role also
        Admin::create([
            'name' => 'Gab Admin',
            'email' => 'jjgab@example.com',
            'password' => Hash::make('12341234'),
            'role' => 'admin',
        ]);
        // password sa staff staffpassword123
    }
}

