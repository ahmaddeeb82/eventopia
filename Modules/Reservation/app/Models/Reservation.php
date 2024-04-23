<?php

namespace Modules\Reservation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Event\Models\ServiceAsset;
use Modules\Reservation\Database\Factories\ReservationFactory;
use Modules\User\Models\User;

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
        'duration',
        'payment',
        'total_price',
        'notes',
        'phone',
        'confirmed_guest_id',
        'event_id',
    ];

    protected $table = 'reservations';

    public function user() {
        $this->belongsTo(User::class,'confirmed_guest_id');
    }

    public function serviceAsset() {
        $this->belongsTo(ServiceAsset::class, 'event_id');
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

}
