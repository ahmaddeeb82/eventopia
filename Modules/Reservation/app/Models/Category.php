<?php

namespace Modules\Reservation\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Reservation\Database\Factories\CategoryFactory;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations, SoftDeletes,CascadeSoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
    ];



    public $translatable = ['name'];


    protected $cascadeDeletes = ['publicEvents'];

    protected $dates = ['deleted_at'];

    public function publicEvents() {
        return $this->hasMany(PublicEvent::class, 'category_id', 'id');
    }
}
