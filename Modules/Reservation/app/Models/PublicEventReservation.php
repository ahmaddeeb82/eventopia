<?php

namespace Modules\Reservation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Favorite\Interfaces\Favoritable;
use Modules\Favorite\Models\Favorite;
use Modules\Reservation\Database\Factories\PublicEventReservationFactory;
use Modules\User\Models\User;

class PublicEventReservation extends Model implements Favoritable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'payment',
        'tickets_price',
        'tickets_number',
        'event_id',
        'user_id',
    ];

    protected $table = 'public_event_reservations';

    public function publicEvent() {
        return $this->belongsTo(PublicEvent::class, 'event_id','id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function favorites() {
        return $this->morphMany(Favorite::class, 'favoritable');
    }
}
