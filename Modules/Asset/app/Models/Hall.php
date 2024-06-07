<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Asset\Database\Factories\HallFactory;
use Spatie\Translatable\HasTranslations;

class Hall extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'capacity',
        'dinner',
        'dinner_price',
        'mixed',
        'mixed_price',
        //'active_times',
        'name',
        'address',
        'asset_id',
    ];

    protected $table = 'halls';

    public $translatable = ['name'];

    public function asset() {
        return $this->belongsTo(Asset::class,'asset_id', 'id');
    }

    public function times() {
        return $this->hasMany(Time::class, 'hall_id', 'id');
    }
    
}
