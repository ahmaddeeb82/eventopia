<?php

namespace Modules\Event\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Event\Database\Factories\PublicEventProportionFactory;

class PublicEventProportion extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'proportion',
        'event_id',
    ];

    protected $table = 'public_event_proportion';

    public  function serviceAsset() {
        return $this->belongsTo(ServiceAsset::class, 'event_id', 'id');
    }

    
}
