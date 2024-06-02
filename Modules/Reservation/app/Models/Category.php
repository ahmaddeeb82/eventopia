<?php

namespace Modules\Reservation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Reservation\Database\Factories\CategoryFactory;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
    ];

    public $translatable = ['name'];

    public function publicEvents() {
        return $this->hasMany(PublicEvent::class, 'category_id', 'id');
    }
}
