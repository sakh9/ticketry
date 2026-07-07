<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class Visitor extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $primaryKey = 'id_visitor';
    protected $guard_name = 'visitor';

    protected $fillable = [
        'nama_visitor', 
        'nik_visitor', 
        'no_hp_visitor',
        'foto_visitor', 
        'email_visitor', 
        'password',
        'timezone', 
        'is_banned', 
        'banned_at', 
        'ban_reason',
    ];

    protected $hidden = ['password', 'remember_token'];
    protected $casts = [
        'password' => 'hashed',
        'is_banned' => 'boolean',
        'banned_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_visitor', 'id_visitor');
    }
}