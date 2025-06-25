<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $table = 'cities';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'state_id',
        'latitude',
        'longitude',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the state that owns the city.
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Get the country that the city belongs to through state.
     */
    public function country()
    {
        return $this->state->country();
    }

    /**
     * Get the universities in this city.
     */
    public function universities(): HasMany
    {
        return $this->hasMany(University::class);
    }
}
