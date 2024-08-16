<?php

namespace Modules\Reservation\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Modules\User\Models\User;
use Modules\Asset\Models\Asset;
use Modules\Event\Models\Service;
use Modules\Event\Models\ServiceAsset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Asset\Models\Time;
use Modules\Reservation\Database\Factories\ReservationFactory;

class Reservation extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'attendees_number',
        'start_date',
        'end_date',
        'duration',
        'payment',
        'total_price',
        'notes',
        'phone',
        'confirmed_guest_id',
        'event_id',
        'time_id',
        'mixed',
        'dinner'
    ];

    protected $table = 'reservations';

    protected $cascadeDeletes = ['publicEvent', 'publicEventReservations'];

    protected $dates = ['deleted_at'];

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

    public function service() {
        return $this->belongsTo(Service::class, 'event_id', 'id');
    }

    public function time(){
        return $this -> belongsTo(Time::class, 'time_id', 'id');
    }

}
