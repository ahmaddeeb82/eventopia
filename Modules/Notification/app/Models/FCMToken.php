<?php

namespace Modules\Notification\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Notification\Database\Factories\FCMTokenFactory;
use Modules\User\Models\User;

class FCMToken extends Model
{
    use HasFactory, SoftDeletes;

    
    protected $fillable = ['user_id', 'token'];

    protected $table = 'fcm_tokens';

    public function user() {
        return $this->BelongsTo(User::class,'user_id', 'id');
    }

}
