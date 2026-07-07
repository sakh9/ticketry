<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $primaryKey = 'id_admin';
    protected $guard_name = 'admin';

    protected $fillable = [
        'id_admin',
        'nama_admin',
        'email_admin',
        'password',
        'timezone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function reviewedEvents()
    {
        return $this->hasMany(Event::class, 'reviewed_by', 'id_admin');
    }
}