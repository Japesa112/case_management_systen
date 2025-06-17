<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Lawyer;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;



class User extends Authenticatable
{
    use  Notifiable;

    protected $table = 'users'; // Specify the table name explicitly

    protected $primaryKey = 'user_id'; // Set the primary key to 'user_id'

    public $timestamps = false; // Disable timestamps if not using Laravel's 'created_at' and 'updated_at'

    protected $fillable = [
        'username', 'email', 'password_hash', 'full_name', 'phone', 'role', 'account_status', 'created_at', 'last_login'
    ];

    protected $hidden = [
        'password_hash', 'remember_token',
    ];

    public function lawyer()
{
    return $this->hasOne(Lawyer::class, 'user_id');
}

public function notifications()
{
    return $this->belongsToMany(Notification::class, 'user_notification', 'user_id', 'notification_id')
                ->withPivot('is_read', 'read_at')
                ->withTimestamps();
}

 public function getAuthPassword()
    {
        return $this->password_hash;
    }

     public function getAuthIdentifierName()
    {
        return 'user_id';
    }


}
