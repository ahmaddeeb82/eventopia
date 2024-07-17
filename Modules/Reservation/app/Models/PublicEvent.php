<?php

namespace Modules\Reservation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Reservation\Database\Factories\PublicEventFactory;
use Modules\User\Models\User;
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
        'reserved_tickets',
        'reservation_id',
        'category_id',
    ];

    protected $table = 'extra_public_events';

    public $translatable = ['category'];

    public function reservation() {
        return $this->belongsTo(Reservation::class, 'reservation_id','id');
    }

    public function publicEventReservations() {
        return $this->hasMany(PublicEventReservation::class, 'event_id','id');
    }

    public function usersFavorite()
    {
        return $this->morphToMany(User::class, 'favoritable');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    
}
