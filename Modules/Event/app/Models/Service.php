<?php

namespace Modules\Event\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Asset\Models\Asset;
use Modules\Event\Database\Factories\ServiceFactory;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'service_kind',
        'service_name',
    ];

    protected $table = 'services';

    public function serviceAssets() {
        return $this->belongsToMany(Asset::class, 'service_asset', 'service_id', 'asset_id');
    }

}
