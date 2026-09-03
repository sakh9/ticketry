<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\Organizer;
use App\Models\Visitor;
use Illuminate\Console\Command;

class AssignSpatieRoles extends Command
{
    protected $signature = 'ticketry:assign-roles';
    protected $description = 'Assign Spatie roles to all users';

    public function handle(): void
    {
        Admin::all()->each(fn($u) => $u->assignRole('admin'));
        Organizer::all()->each(fn($u) => $u->assignRole('organizer'));
        Visitor::all()->each(fn($u) => $u->assignRole('visitor'));

        $this->info('Roles assigned!');
    }
}