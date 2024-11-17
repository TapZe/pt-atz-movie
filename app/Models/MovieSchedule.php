<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovieSchedule extends Model
{
    use SoftDeletes, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'show_start',
        'show_end',
        'price_id',
        'movie_id',
        'auditorium_id',
    ];

    /**
     * Get the auditorium that owns the Movieschedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function auditorium(): BelongsTo
    {
        return $this->belongsTo(Auditorium::class);
    }

    /**
     * Get the movie that owns the Movieschedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * The seat that belong to the MovieSchedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function seat(): BelongsToMany
    {
        return $this->belongsToMany(Seat::class, 'movie_schedule_seats')
            ->using(MovieScheduleSeat::class)
            ->withPivot(['user_id', 'payyed', 'arrived', 'payment_id'])
            ->withTimestamps();
    }

    /**
     * Get the price that owns the MovieSchedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function price(): BelongsTo
    {
        return $this->belongsTo(Price::class);
    }
}
