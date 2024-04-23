<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Asset\Database\Factories\HallFactory;

class Hall extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'capacity',
        'dinner',
        'mixed',
        'active_times',
        'name',
        'asset_id',
    ];

    public function asset() {
        return $this->belongsTo(Asset::class,'asset_id', 'id');
    }
    
}
