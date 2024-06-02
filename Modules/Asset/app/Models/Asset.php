<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Asset\Database\Factories\AssetFactory;
use Modules\Event\Models\Service;
use Modules\Event\Models\ServiceAsset;
use Modules\Favorite\Interfaces\Favoritable;
use Modules\Favorite\Models\Favorite;
use Modules\Reservation\Models\Reservation;
use Modules\User\Models\User;

class Asset extends Model implements Favoritable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'photos',
        'rate',
        'user_id',
        'rated_number',
    ];

    protected $table = 'assets';

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function serviceAssets() {
        return $this->hasMany(ServiceAsset::class, 'asset_id', 'id');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function services() {
        return $this->belongsToMany(Service::class, 'service_asset', 'asset_id', 'service_id');
    }

    public function servicesWithPrice() {
        return $this->belongsToMany(Service::class, 'service_asset', 'asset_id', 'service_id')->withPivot('price');
    }

    public function hall() {
        return $this->hasOne(Hall::class, 'asset_id','id');
    }

    public function reservations() {
        return $this->hasManyThrough(
            Reservation::class,
            ServiceAsset::class,
            'asset_id',
            'event_id',
            'id',
            'id'
        );
    }
}
