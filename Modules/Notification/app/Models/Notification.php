<?php

namespace Modules\Notification\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Notification\Database\Factories\NotificationFactory;
use Modules\User\Models\User;

class Notification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'type',
        'description',
    ];

    protected $table = 'notifications';

    public function users() {
        return $this->belongsToMany(User::class, 'user_notifications', 'notification_id','user_id');
    }
}
