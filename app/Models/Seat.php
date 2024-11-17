<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seat extends Model
{
    use SoftDeletes, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['seat_code'];

    /**
     * The movieSchedule that belong to the Seat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function movieSchedule(): BelongsToMany
    {
        return $this->belongsToMany(MovieSchedule::class, 'movie_schedule_seats')
            ->using(MovieScheduleSeat::class)
            ->withPivot('booked')
            ->withTimestamps();
    }
}
