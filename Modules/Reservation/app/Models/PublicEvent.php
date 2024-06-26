<?php

namespace Modules\Reservation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Reservation\Database\Factories\PublicEventFactory;
use Spatie\Translatable\HasTranslations;

class PublicEvent extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'category',
        'description',
        'photo',
        'name',
        'address',
        'ticket_price',
        'total_tickets',
        'reserved_tickets',
        'reservation_id',
    ];

    protected $table = 'extra_public_events';

    public $translatable = ['category'];

    public function reservation() {
        $this->belongsTo(Reservation::class, 'reservation_id','id');
    }

    public function publicEventReservations() {
        $this->hasMany(PublicEventReservation::class, 'event_id','id');
    }

    
}
