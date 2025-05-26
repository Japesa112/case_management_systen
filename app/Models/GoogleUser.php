<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoogleUser extends Authenticatable
{
    use HasFactory, Notifiable;

    // Use custom table name only if not 'users'
    // protected $table = 'google_users';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'google_id',
        'password',
        'logged_in_at',
        'logged_out_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google_id',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'logged_in_at' => 'datetime',
        'logged_out_at' => 'datetime',
    ];
}
