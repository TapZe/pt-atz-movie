<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'id'];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The movie that belong to the Genre
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function movie(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'movie_genre')
            ->using(MovieGenre::class)
            ->withTimestamps();
    }
}
