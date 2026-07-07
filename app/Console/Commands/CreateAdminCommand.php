<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminCommand extends Command
{
    protected $signature = 'cikieto:create-admin 
                            {id_admin : Admin ID}
                            {nama_admin : Admin name}
                            {email : Admin email}
                            {password : Admin password}';

    protected $description = 'Create a new admin user';

    public function handle(): void
    {
        $idAdmin = $this->argument('id_admin');
        $namaAdmin = $this->argument('nama_admin');
        $email = $this->argument('email');
        $password = $this->argument('password');

        if (Admin::where('id_admin', $idAdmin)->exists()) {
            $this->error("Admin with ID '{$idAdmin}' already exists!");
            return;
        }

        $admin = Admin::create([
            'id_admin' => $idAdmin,
            'nama_admin' => $namaAdmin,
            'email_admin' => $email,
            'password' => Hash::make($password),
        ]);

        // Assign admin role
        $admin->assignRole('admin');

        $this->info("Admin '{$namaAdmin}' created successfully!");
        $this->info("ID: {$idAdmin}");
        $this->info("Email: {$email}");
    }
}