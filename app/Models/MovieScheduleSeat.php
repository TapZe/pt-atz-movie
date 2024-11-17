<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MovieScheduleSeat extends Pivot
{
    protected $fillable = ['user_id', 'payyed', 'arrived', 'payment_id'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'movie_schedule_seats';

    /**
     * Get the seat that owns the MoviescheduleSeat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class);
    }

    /**
     * Get the movieSchedule that owns the MovieScheduleSeat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movieSchedule(): BelongsTo
    {
        return $this->belongsTo(MovieSchedule::class);
    }

    /**
     * Get the user that owns the MovieScheduleSeat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
