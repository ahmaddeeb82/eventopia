<?php

namespace Modules\Discounts\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Discounts\Database\Factories\DiscountFactory;
use Modules\Event\Models\ServiceAsset;

class Discount extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'percentage',
        'disconted_price',
        'start_date',
        'end_date',
        'duration',
        'active',
        'event_id',
    ];

    protected $table = 'discounts';

    public function serviceAsset() {
        return $this->belongsTo(ServiceAsset::class, 'event_id', 'id');
    }

}
