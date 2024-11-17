<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promo extends Model
{
    use SoftDeletes, HasUuids;

    protected $fillable = [
        'name',
        'description',
        'image',
        'code',
        'type',
        'discount',
        'start_date',
        'end_date',
    ];

    /**
     * The user that belong to the Promo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_promo')
            ->using(UserPromo::class)
            ->withPivot('used')
            ->withTimestamps();
    }
}
