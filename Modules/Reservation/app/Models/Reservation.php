<?php

namespace Modules\Reservation\Models;

use Modules\User\Models\User;
use Modules\Asset\Models\Asset;
use Modules\Event\Models\Service;
use Modules\Event\Models\ServiceAsset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Asset\Models\Time;
use Modules\Reservation\Database\Factories\ReservationFactory;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'attendees_number',
        'start_date',
        'end_date',
        //'start_time',
        //'end_time',
        'duration',
        'payment',
        'total_price',
        'notes',
        'phone',
        'confirmed_guest_id',
        'event_id',
        'time_id',
    ];

    protected $table = 'reservations';

    public function user() {
       return $this->belongsTo(User::class,'confirmed_guest_id');
    }

    public function serviceAsset() {
       return $this->belongsTo(ServiceAsset::class, 'event_id');
    }

    public function publicEvent() {
        return $this->hasOne(PublicEvent::class, 'reservation_id', 'id');
    }

    public function publicEventReservations() {
        return $this->hasManyThrough(
            PublicEventReservation::class,
            PublicEvent::class,
            'reservation_id',
            'event_id',
            'id',
            'id'
        );
    }

    public function assets() {
        return $this->belongsTo(Asset::class, 'event_id', 'id');
    }

    public function services() {
        return $this->belongsTo(Service::class, 'event_id', 'id');
    }

    public function time(){
        return $this -> belongsTo(Time::class, 'time_id', 'id');
    }

}
