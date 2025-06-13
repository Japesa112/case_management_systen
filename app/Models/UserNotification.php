<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserNotification extends Pivot
{
    protected $table = 'user_notification';

    protected $fillable = [
        'user_id',
        'notification_id',
        'is_read',
        'read_at',
        'created_at',
        'updated_at'
    ];

    //public $timestamps = false;

    /**
     * Optional: relationships back to User or Notification
     */
    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
