<?php

namespace Modules\Favorite\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\User;

class Favorite extends Model
{
    protected $fillable = ['user_id', 'favoritable_id', 'favoritable_type'];

    public function favoritable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
