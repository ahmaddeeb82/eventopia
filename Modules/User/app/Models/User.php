<?php

namespace Modules\User\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Modules\Chat\Models\Chat;
use Modules\Asset\Models\Asset;
use Laravel\Sanctum\HasApiTokens;
use Modules\Contracts\Models\Contract;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Modules\Reservation\Models\Reservation;
use Modules\Favorite\Interfaces\Favoritable;
use Modules\Notification\Models\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Reservation\Models\PublicEventReservation;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Event\Models\ServiceAsset;
use Modules\Reservation\Models\PublicEvent;

class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable, HasRoles,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'address',
        'photo',
        'phone_number',
        'email_verified_at',
        'money'
    ];

    protected $guard_name = 'web';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'users';

    public function contracts() {
        return $this->hasMany(Contract::class, 'user_id', 'id');
    }

    public function notifications() {
        return $this->belongsToMany(Notification::class,'user_notifications', 'user_id', 'notification_id');
    }

    public function assets() {
        return $this->hasMany(Asset::class, 'user_id', 'id');
    }


    public function publicEventReservations() {
        return $this->hasMany(PublicEventReservation::class, 'user_id', 'id');
    }

    public function chatSender() {
        return $this->hasMany(Chat::class,'sender_id', 'id');
    }

    public function chatReciever() {
        return $this->hasMany(Chat::class,'reciever_id', 'id');
    }

    public function favoriteAssets()
    {
        return $this->morphedByMany(Asset::class, 'favoritable')->withPivot('id');
    }
    public function favoritePublicEvents()
    {
        return $this->morphedByMany(PublicEvent::class, 'favoritable');
    }


    public function reservations() {
        return $this->hasMany(Reservation::class,'confirmed_guest_id','id');
    }

    public function serviceAssets()
    {
        return $this->hasManyThrough(ServiceAsset::class, Asset::class);
    }


}
