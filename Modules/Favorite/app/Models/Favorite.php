<?php

namespace Modules\Favorite\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Favorite\Database\Factories\FavoriteFactory;

class Favorite extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'favoritable_type',
        'favoritable_id',
    ];

    protected $table = 'favoritables';

    
}
