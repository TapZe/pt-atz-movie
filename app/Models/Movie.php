<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use SoftDeletes, HasUuids;

    protected $fillable = [
        'third_party_id',
        'original_title',
        'title',
        'original_language',
        'overview',
        'release_date',
        'backdrop_path',
        'poster_path',
        'adult',
        'popularity',
        'vote_average',
        'vote_count',
        'runtime'
    ];

    protected $casts = [
        'release_date' => 'date',
        'adult' => 'boolean',
        'popularity' => 'float',
        'vote_average' => 'float',
        'vote_count' => 'integer',
    ];

    /**
     * The genre that belong to the Movie
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function genre(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'movie_genre')
            ->using(MovieGenre::class)
            ->withTimestamps();
    }

    /**
     * Get all of the movieSchedule for the Movie
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movieSchedule(): HasMany
    {
        return $this->hasMany(MovieSchedule::class);
    }
}
