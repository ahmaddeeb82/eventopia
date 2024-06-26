<?php

namespace Modules\Contracts\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Contracts\Database\Factories\ContractFactory;
use Modules\User\Models\User;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'price',
        'start_date',
        'end_date',
        'duration',
        'user_id',
    ];

    protected $table = 'contracts';

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
