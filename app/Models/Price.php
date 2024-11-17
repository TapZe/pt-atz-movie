<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
    use SoftDeletes, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'number'];

    /**
     * Get all of the movieSchedule for the Price
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movieSchedule(): HasMany
    {
        return $this->hasMany(MovieSchedule::class);
    }
}
