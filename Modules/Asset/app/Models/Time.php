<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Asset\Database\Factories\TimeFactory;
use Modules\Reservation\Models\Reservation;

class Time extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'start_time',
        'end_time',
        'hall_id'
    ];

    public function hall() {
        return $this->belongsTo(Hall::class,'hall_id','id');
    }

    public function reservation(){
        return $this -> hasMany(Reservation::class, 'time_id', 'id');
    }

    
}
