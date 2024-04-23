<?php

namespace Modules\Chat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Chat\Database\Factories\ChatFactory;
use Modules\User\Models\User;

class Chat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'sender_id',
        'reciever_id',
        'connection_name',
    ];

    protected $table = 'chats';

    public function sender() {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function reciever() {
        return $this->belongsTo(User::class, 'reciever_id', 'id');
    }

    
}
