<?php

namespace Modules\Event\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Discounts\Models\Discount;
use Modules\Event\Database\Factories\ServiceAssetFactory;

class ServiceAsset extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'asset_id',
        'service_id',
        'price',
    ];

    protected $table = 'service_asset';

    public function proportion() {
        return $this->hasOne(PublicEventProportion::class,'event_id','id');
    }

    public function discounts() {
        return $this->hasMany(Discount::class,'event_id', 'id');
    }

    
}
