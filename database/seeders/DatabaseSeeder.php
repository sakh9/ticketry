<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(SpatieRolePermissionSeeder::class);

        Admin::create([
            'nama_admin' => 'SuperAdmin',
            'email_admin' => 'superadmin@ticketry.com',
            'password' => Hash::make('password123'),
        ]);

        Admin::first()->assignRole('admin');
    }
}