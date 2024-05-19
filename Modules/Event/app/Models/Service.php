<?php

namespace Modules\Event\Models;

use Modules\Asset\Models\Asset;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Modules\Reservation\Models\Reservation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Event\Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'kind',
        'name',
        'active',
    ];

    protected $table = 'services';

    public $translatable = ['name'];

    public function assets() {
        return $this->belongsToMany(Asset::class, 'service_asset', 'service_id', 'asset_id');
    }

    public function reservations() {
        return $this->hasManyThrough(
            Reservation::class,
            ServiceAsset::class,
            'service_id',
            'event_id',
            'id',
            'id'
        );
    }

}
