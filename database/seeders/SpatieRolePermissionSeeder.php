<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SpatieRolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions
        Permission::create(['name' => 'manage-users', 'guard_name' => 'admin']);
        Permission::create(['name' => 'review-proposals', 'guard_name' => 'admin']);
        Permission::create(['name' => 'view-reports', 'guard_name' => 'admin']);
        Permission::create(['name' => 'manage-locations', 'guard_name' => 'admin']);
        Permission::create(['name' => 'manage-admins', 'guard_name' => 'admin']);

        Permission::create(['name' => 'create-events', 'guard_name' => 'organizer']);
        Permission::create(['name' => 'view-sales', 'guard_name' => 'organizer']);
        Permission::create(['name' => 'edit-profile', 'guard_name' => 'organizer']);

        Permission::create(['name' => 'browse-events', 'guard_name' => 'visitor']);
        Permission::create(['name' => 'buy-tickets', 'guard_name' => 'visitor']);
        Permission::create(['name' => 'view-tickets', 'guard_name' => 'visitor']);

        // Roles
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'admin']);
        $adminRole->givePermissionTo(Permission::where('guard_name', 'admin')->get());

        $organizerRole = Role::create(['name' => 'organizer', 'guard_name' => 'organizer']);
        $organizerRole->givePermissionTo(Permission::where('guard_name', 'organizer')->get());

        $visitorRole = Role::create(['name' => 'visitor', 'guard_name' => 'visitor']);
        $visitorRole->givePermissionTo(Permission::where('guard_name', 'visitor')->get());
    }
}