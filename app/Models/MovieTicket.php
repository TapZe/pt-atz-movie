<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovieTicket extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'movie_schedule_seat_id'];

    /**
     * Get the user that owns the MovieTicket
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the movieScheduleSeat that owns the MovieTicket
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movieScheduleSeat(): BelongsTo
    {
        return $this->belongsTo(MovieScheduleSeat::class);
    }
}
