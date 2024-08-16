<?php

namespace Modules\Asset\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Asset\Database\Factories\TimeFactory;
use Modules\Reservation\Models\Reservation;

class Time extends Model
{
    use HasFactory,SoftDeletes, CascadeSoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'start_time',
        'end_time',
        'asset_id'
    ];


    protected $cascadeDeletes = ['reservation'];

    protected $dates = ['deleted_at'];

    public function asset() {
        return $this->belongsTo(Asset::class,'asset_id','id');
    }

    public function reservation(){
        return $this -> hasMany(Reservation::class, 'time_id', 'id');
    }

    
}
