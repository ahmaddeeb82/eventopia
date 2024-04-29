<?php

namespace Modules\Event\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Asset\Models\Asset;
use Modules\Event\Database\Factories\ServiceFactory;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'kind',
        'name',
    ];

    protected $table = 'services';

    public $translatable = ['name'];

    public function assets() {
        return $this->belongsToMany(Asset::class, 'service_asset', 'service_id', 'asset_id');
    }

}
