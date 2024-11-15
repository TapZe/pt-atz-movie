<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MovieScheduleSeat extends Pivot
{
    protected $fillable = ['booked'];

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
     * Get the ticket associated with the MovieScheduleSeat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ticket(): HasOne
    {
        return $this->hasOne(MovieTicket::class);
    }
}
