<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Notification extends Model
{
    protected $primaryKey = 'notification_id';

    protected $fillable = [
        'title',
        'message',
        'type',
        'icon',
    ];

    public $timestamps = ['created_at'];
    public $updated_at = false;

    /**
     * Users who received the notification.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_notification', 'notification_id', 'user_id')
                    ->withPivot('is_read', 'read_at')
                    ->withTimestamps();
    }
}
