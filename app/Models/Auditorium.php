<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Auditorium extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'cinema_id'];

    /**
     * Get the cinema that owns the Auditorium
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cinema(): BelongsTo
    {
        return $this->belongsTo(Cinema::class);
    }

    /**
     * Get all of the movieSchedule for the Auditorium
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movieSchedule(): HasMany
    {
        return $this->hasMany(MovieSchedule::class);
    }
}
