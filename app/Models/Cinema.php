<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cinema extends Model
{
    use SoftDeletes, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'city',
        'address',
        'open_time',
        'close_time'
    ];

    /**
     * Get all of the auditorium for the Cinema
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function auditorium(): HasMany
    {
        return $this->hasMany(Auditorium::class);
    }
}
