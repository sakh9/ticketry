<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class Organizer extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $primaryKey = 'id_organizer';
    protected $guard_name = 'organizer';

    protected $fillable = [
        'nama_organizer', 
        'nama_penanggungjawab', 
        'no_hp_organizer',
        'email_organizer', 
        'password', 
        'deskripsi_organizer',
        'logo_organizer', 
        'instagram', 
        'linkedin',
        'bank_code', 
        'bank_name', 
        'bank_account_number', 
        'bank_account_name',
        'timezone', 
        'category_id', 
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

    public function events()
    {
        return $this->hasMany(Event::class, 'id_organizer', 'id_organizer');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}